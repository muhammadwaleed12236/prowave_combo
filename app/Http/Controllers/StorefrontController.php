<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Setting;
use App\Models\EcommerceOrder;
use App\Models\EcommerceOrderItem;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StorefrontController extends Controller
{
    /**
     * Get all website settings as key-value associative array
     */
    protected function getSettings()
    {
        return Setting::pluck('value', 'key')->toArray();
    }

    /**
     * Helper to transform product data (fallback images, final price, stock)
     */
    protected function transformProduct($product)
    {
        $product->final_price = $product->web_sale_price ?: ($product->sale_price_per_piece ?: $product->sale_price_per_box);
        $product->total_stock = (int) ($product->total_stock ?? 0);
        
        // Calculate discount percentage
        $product->discount_percent = 0;
        if ($product->web_sale_price && $product->sale_price_per_piece && $product->sale_price_per_piece > $product->web_sale_price) {
            $diff = $product->sale_price_per_piece - $product->web_sale_price;
            $product->discount_percent = round(($diff / $product->sale_price_per_piece) * 100);
        }

        // Parse Variants (Sizes & Colors)
        $product->parsed_sizes = [];
        $product->parsed_colors = [];
        $product->variants = [];

        if (!empty($product->color)) {
            try {
                $parsed = json_decode($product->color, true);
                if (is_array($parsed) && count($parsed) > 0) {
                    if (is_string($parsed[0])) {
                        $product->parsed_colors = $parsed;
                    } elseif (is_array($parsed[0])) {
                        $product->variants = $parsed;
                        $sizes = [];
                        $colors = [];
                        foreach ($parsed as $v) {
                            if (!empty($v['size']) && $v['size'] !== '-') {
                                $sizes[] = $v['size'];
                            }
                            if (!empty($v['color']) && $v['color'] !== '-') {
                                $colors[] = $v['color'];
                            }
                        }
                        $product->parsed_sizes = array_values(array_unique($sizes));
                        $product->parsed_colors = array_values(array_unique($colors));
                    }
                }
            } catch (\Exception $e) {
                // Ignore parse errors
            }
        }

        // Primary Image & Fallback
        $placeholders = [
            '/placeholders/outfitter_prod_1.jpg',
            '/placeholders/outfitter_prod_2.jpg',
            '/placeholders/outfitter_prod_3.jpg',
            '/placeholders/outfitter_prod_4.jpg',
            '/placeholders/outfitter_prod_5.jpg',
            '/placeholders/outfitter_prod_6.jpg',
            '/placeholders/outfitter_prod_7.jpg',
            '/placeholders/outfitter_prod_8.jpg',
            '/placeholders/product_1_main.jpg',
            '/placeholders/product_2_main.jpg',
            '/placeholders/product_3_main.jpg',
            '/placeholders/product_4_main.jpg',
            '/placeholders/product_5_main.jpg',
            '/placeholders/product_6_main.jpg',
            '/placeholders/product_7_main.jpg',
        ];
        $fallback = $placeholders[abs($product->id) % count($placeholders)];

        $mainImg = null;
        if (!empty($product->web_main_image)) {
            $mainImg = '/' . ltrim($product->web_main_image, '/');
        } elseif (!empty($product->image)) {
            $mainImg = '/' . ltrim($product->image, '/');
            if (!str_starts_with($mainImg, '/uploads')) {
                $mainImg = '/uploads/products/' . ltrim($mainImg, '/');
            }
        }

        $product->display_image = $mainImg ?: $fallback;

        // Gallery images
        $gallery = [$product->display_image];
        if ($product->webImages && count($product->webImages) > 0) {
            foreach ($product->webImages as $wi) {
                $path = '/' . ltrim($wi->image_path, '/');
                if (!in_array($path, $gallery)) {
                    $gallery[] = $path;
                }
            }
        }
        $product->gallery_images = $gallery;

        return $product;
    }

    /**
     * Homepage
     */
    public function index()
    {
        $settings = $this->getSettings();

        // Categories
        $categories = Category::where('show_on_website', 1)
            ->orWhereNull('show_on_website')
            ->orderBy('id', 'asc')
            ->get();

        // Fetch products with stock
        $productsQuery = Product::with(['category_relation', 'webImages'])
            ->withSum('warehouseStocks as total_stock', 'total_pieces')
            ->whereNull('deleted_at');

        $allRawProducts = $productsQuery->orderBy('id', 'desc')->take(50)->get();

        $allProducts = $allRawProducts->map(function ($p) {
            return $this->transformProduct($p);
        });

        // New Arrivals
        $newArrivals = $allProducts->filter(function ($p) {
            return $p->promo_tag === 'New Arrival';
        })->values();

        if ($newArrivals->count() < 4) {
            $newArrivals = $allProducts->take(8);
        }

        // Best Sellers
        $bestSellers = $allProducts->filter(function ($p) {
            return in_array($p->promo_tag, ['Best Seller', 'Trending', 'Featured']);
        })->values();

        if ($bestSellers->count() < 4) {
            $bestSellers = $allProducts->slice(2, 8)->values();
        }

        return view('storefront.index', compact('settings', 'categories', 'allProducts', 'newArrivals', 'bestSellers'));
    }

    /**
     * Shop / Catalog Page
     */
    public function shop(Request $request)
    {
        $settings = $this->getSettings();
        $categories = Category::where('show_on_website', 1)->orWhereNull('show_on_website')->get();

        $query = Product::with(['category_relation', 'webImages'])
            ->withSum('warehouseStocks as total_stock', 'total_pieces')
            ->whereNull('deleted_at');

        // Filter by category
        if ($request->filled('category')) {
            $cat = $request->category;
            $query->where(function ($q) use ($cat) {
                $q->where('category_id', $cat)
                  ->orWhereHas('category_relation', function ($subQ) use ($cat) {
                      $subQ->where('name', $cat);
                  });
            });
        }

        // Filter by Promo Tag
        if ($request->filled('tag')) {
            $query->where('promo_tag', $request->tag);
        }

        // Search Keyword
        if ($request->filled('q')) {
            $kw = $request->q;
            $query->where(function ($q) use ($kw) {
                $q->where('item_name', 'like', "%{$kw}%")
                  ->orWhere('item_code', 'like', "%{$kw}%");
            });
        }

        // Sort
        if ($request->get('sort') === 'price_asc') {
            $query->orderBy('sale_price_per_piece', 'asc');
        } elseif ($request->get('sort') === 'price_desc') {
            $query->orderBy('sale_price_per_piece', 'desc');
        } else {
            $query->orderBy('id', 'desc');
        }

        $paginator = $query->paginate(24)->withQueryString();

        $paginator->getCollection()->transform(function ($p) {
            return $this->transformProduct($p);
        });

        return view('storefront.shop', compact('settings', 'categories', 'paginator'));
    }

    /**
     * Single Product Detail Page
     */
    public function product($id)
    {
        $settings = $this->getSettings();

        $rawProduct = Product::with(['category_relation', 'webImages'])
            ->withSum('warehouseStocks as total_stock', 'total_pieces')
            ->whereNull('deleted_at')
            ->findOrFail($id);

        $product = $this->transformProduct($rawProduct);

        // Related Products
        $relatedProducts = Product::with(['category_relation', 'webImages'])
            ->withSum('warehouseStocks as total_stock', 'total_pieces')
            ->whereNull('deleted_at')
            ->where('id', '!=', $product->id)
            ->where('category_id', $product->category_id)
            ->take(4)
            ->get()
            ->map(function ($p) {
                return $this->transformProduct($p);
            });

        return view('storefront.product', compact('settings', 'product', 'relatedProducts'));
    }

    /**
     * Checkout Page
     */
    public function checkout()
    {
        $settings = $this->getSettings();
        return view('storefront.checkout', compact('settings'));
    }

    /**
     * Place Order Web Handler
     */
    public function placeOrder(Request $request)
    {
        $messages = [
            'shipping_name.required' => 'Please enter your Full Name.',
            'shipping_phone.required' => 'Please enter your Mobile / WhatsApp Number.',
            'shipping_address.required' => 'Please enter your complete Delivery Address.',
            'shipping_city.required' => 'Please enter your City.',
            'payment_method.required' => 'Please select a Payment Method.',
            'cart_data.required' => 'Your shopping bag is empty. Please add items to your cart before proceeding to checkout.',
        ];

        $request->validate([
            'shipping_name' => 'required|string|max:255',
            'shipping_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string|max:500',
            'shipping_city' => 'required|string|max:100',
            'payment_method' => 'required|string|in:COD,Easypaisa,Bank Transfer',
            'cart_data' => 'required',
        ], $messages);

        $cartItems = is_array($request->cart_data) 
            ? $request->cart_data 
            : json_decode($request->cart_data, true);

        if (!is_array($cartItems) || count($cartItems) === 0) {
            return back()->withInput()->withErrors([
                'cart_data' => 'Your shopping bag is empty. Please add items to your cart before proceeding to checkout.'
            ]);
        }

        DB::beginTransaction();
        try {
            $subtotal = 0;
            $orderItems = [];

            foreach ($cartItems as $item) {
                $prod = Product::find($item['id']);
                if (!$prod) continue;

                $price = $prod->web_sale_price ?: ($prod->sale_price_per_piece ?: $prod->sale_price_per_box);
                $qty = max(1, (int) ($item['quantity'] ?? 1));
                $lineTotal = $price * $qty;
                $subtotal += $lineTotal;

                $orderItems[] = [
                    'product_id' => $prod->id,
                    'product_name' => $prod->item_name,
                    'price' => $price,
                    'quantity' => $qty,
                    'subtotal' => $lineTotal,
                    'size' => $item['selectedSize'] ?? null,
                    'color' => $item['selectedColor'] ?? null,
                ];
            }

            $shippingCost = $subtotal >= 5000 ? 0 : 250;
            $discountAmount = 0;
            $finalTotal = $subtotal + $shippingCost - $discountAmount;

            $orderNumber = 'TH-' . strtoupper(Str::random(6)) . '-' . date('dmy');

            $order = new EcommerceOrder();
            $order->order_number = $orderNumber;
            $order->total = $finalTotal;
            $order->subtotal = $subtotal;
            $order->delivery_charges = $shippingCost;
            $order->discount = $discountAmount;
            $order->discount_amount = $discountAmount;
            $order->order_status = 'pending';
            $order->payment_status = 'pending';
            $order->payment_method = $request->payment_method;
            $order->shipping_name = $request->shipping_name;
            $order->shipping_phone = $request->shipping_phone;
            $order->shipping_address = $request->shipping_address;
            $order->shipping_city = $request->shipping_city;
            $order->order_notes = $request->order_notes ?? null;
            $order->transaction_id = $request->transaction_id ?? null;

            // Handle payment screenshot upload if Easypaisa
            if ($request->hasFile('payment_screenshot')) {
                $file = $request->file('payment_screenshot');
                $filename = time() . '_pay_' . Str::random(5) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/payments'), $filename);
                $order->payment_screenshot = 'uploads/payments/' . $filename;
            }

            $order->save();

            foreach ($orderItems as $oi) {
                $itemModel = new EcommerceOrderItem();
                $itemModel->ecommerce_order_id = $order->id;
                $itemModel->product_id = $oi['product_id'];
                $itemModel->product_name = $oi['product_name'];
                $itemModel->price = $oi['price'];
                $itemModel->quantity = $oi['quantity'];
                $itemModel->total = $oi['subtotal'];
                $itemModel->size = $oi['size'];
                $itemModel->color = $oi['color'];
                $itemModel->save();
            }

            DB::commit();

            return redirect()->route('storefront.order_success', ['orderNumber' => $order->order_number]);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to place order: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Order Success Confirmation Page
     */
    public function orderSuccess($orderNumber)
    {
        $settings = $this->getSettings();
        $order = EcommerceOrder::with('items')->where('order_number', $orderNumber)->firstOrFail();

        return view('storefront.order-success', compact('settings', 'order'));
    }

    /**
     * Wishlist Page
     */
    public function wishlist()
    {
        $settings = $this->getSettings();
        return view('storefront.wishlist', compact('settings'));
    }

    /**
     * Store Locator Page
     */
    public function storeLocator()
    {
        $settings = $this->getSettings();
        return view('storefront.store-locator', compact('settings'));
    }
}
