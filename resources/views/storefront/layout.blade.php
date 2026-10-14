<!DOCTYPE html>
<html lang="en" class="h-full scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', ($settings['web_site_name'] ?? 'TrendHub') . ' | Elevated Modern Luxury Menswear')</title>
    <meta name="description" content="@yield('meta_description', 'Discover modern luxury wardrobe staples designed with clean minimal aesthetics and timeless craftsmanship.')">
    <link rel="icon" href="{{ !empty($settings['web_site_logo']) ? asset($settings['web_site_logo']) : asset('favicon.ico') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">

    <!-- Tailwind CSS (CDN - Zero build step, runs instantly on any server) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        serif: ['"Playfair Display"', 'Georgia', 'serif'],
                    },
                    colors: {
                        primary: '#111111',
                        accent: '#7a0f12',
                    }
                }
            }
        }
    </script>

    <!-- Alpine.js (Reactive Storefront: Cart Drawer, Quick View Modal, Wishlist) -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        [x-cloak] { display: none !important; }
        .scrollbar-none::-webkit-scrollbar { display: none; }
        .scrollbar-none { -ms-overflow-style: none; scrollbar-width: none; }
    </style>

    @stack('styles')
</head>
<body 
    x-data="storefrontApp()" 
    x-init="initApp()" 
    class="min-h-full flex flex-col font-sans bg-white text-[#111111] antialiased selection:bg-neutral-900 selection:text-white"
>
    <!-- Top Announcement Marquee Bar -->
    <div class="bg-neutral-950 text-neutral-300 py-2 px-4 text-[10px] sm:text-xs font-medium tracking-[0.2em] uppercase text-center border-b border-neutral-800 flex items-center justify-center gap-3">
        <span>✨ {{ $settings['web_home_banner_text'] ?? 'COMPLIMENTARY NATIONWIDE SHIPPING ON ORDERS OVER PKR 5,000' }}</span>
        <span class="hidden md:inline text-neutral-600">|</span>
        <span class="hidden md:inline">FALL / WINTER 2026 LUXURY MENSWEAR</span>
    </div>

    <!-- Main Navigation Header -->
    <header class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-gray-100 transition-all duration-300">
        <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 h-16 sm:h-20 flex items-center justify-between">
            
            <!-- Left: Mobile Menu Button & Desktop Nav Links -->
            <div class="flex items-center gap-6">
                <!-- Mobile Menu Trigger -->
                <button 
                    @click="mobileMenuOpen = !mobileMenuOpen" 
                    class="lg:hidden p-1.5 text-neutral-800 hover:text-black transition-colors"
                    aria-label="Open Navigation Menu"
                >
                    <i data-lucide="menu" class="w-5 h-5"></i>
                </button>

                <!-- Desktop Nav Links -->
                <nav class="hidden lg:flex items-center gap-7 text-xs font-semibold uppercase tracking-[0.18em] text-neutral-700">
                    <a href="{{ route('storefront.home') }}" class="hover:text-black transition-colors {{ request()->routeIs('storefront.home') ? 'text-black font-bold border-b border-black pb-0.5' : '' }}">Home</a>
                    <a href="{{ route('storefront.shop') }}" class="hover:text-black transition-colors {{ request()->routeIs('storefront.shop') ? 'text-black font-bold border-b border-black pb-0.5' : '' }}">Collections</a>
                    <a href="{{ route('storefront.shop', ['tag' => 'New Arrival']) }}" class="hover:text-black transition-colors">New Arrivals</a>
                    <a href="{{ route('storefront.shop', ['tag' => 'Best Seller']) }}" class="hover:text-black transition-colors">Best Sellers</a>
                    <a href="{{ route('storefront.store_locator') }}" class="hover:text-black transition-colors">Store Locator</a>
                </nav>
            </div>

            <!-- Center: Brand Logo / Typography Name -->
            <div class="text-center">
                <a href="{{ route('storefront.home') }}" class="block select-none group">
                    <span class="font-serif text-xl sm:text-2xl lg:text-3xl font-bold uppercase tracking-[0.25em] text-neutral-900 group-hover:opacity-80 transition-opacity">
                        {{ $settings['web_site_name'] ?? 'TREND HUB' }}
                    </span>
                    <span class="block text-[8px] sm:text-[9px] font-sans tracking-[0.35em] uppercase text-neutral-400 font-medium">
                        EST. 2026 &bull; MENSWEAR
                    </span>
                </a>
            </div>

            <!-- Right: Search, Wishlist, Cart Drawer Trigger -->
            <div class="flex items-center gap-3 sm:gap-4">
                <!-- Search Button -->
                <button 
                    @click="searchModalOpen = true" 
                    class="p-2 text-neutral-800 hover:text-black transition-colors cursor-pointer"
                    aria-label="Search Catalog"
                >
                    <i data-lucide="search" class="w-5 h-5"></i>
                </button>

                <!-- Wishlist Icon -->
                <a 
                    href="{{ route('storefront.wishlist') }}" 
                    class="p-2 text-neutral-800 hover:text-black transition-colors relative cursor-pointer"
                    aria-label="Wishlist"
                >
                    <i data-lucide="heart" class="w-5 h-5"></i>
                    <span 
                        x-show="wishlist.length > 0" 
                        x-text="wishlist.length" 
                        class="absolute top-1 right-1 bg-black text-white text-[9px] font-bold w-4 h-4 rounded-full flex items-center justify-center font-mono"
                    ></span>
                </a>

                <!-- Cart Bag Icon -->
                <button 
                    @click="isCartOpen = true" 
                    class="p-2 text-neutral-800 hover:text-black transition-colors relative cursor-pointer"
                    aria-label="View Shopping Cart"
                >
                    <i data-lucide="shopping-bag" class="w-5 h-5"></i>
                    <span 
                        x-show="cartCount > 0" 
                        x-text="cartCount" 
                        class="absolute top-1 right-1 bg-[#7a0f12] text-white text-[9px] font-bold w-4 h-4 rounded-full flex items-center justify-center font-mono"
                    ></span>
                </button>
            </div>
        </div>

        <!-- Mobile Drawer Navigation -->
        <div 
            x-show="mobileMenuOpen" 
            x-cloak
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="-translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
            class="fixed inset-0 z-50 lg:hidden flex"
        >
            <div class="fixed inset-0 bg-black/60 backdrop-blur-xs" @click="mobileMenuOpen = false"></div>
            <div class="relative bg-white w-4/5 max-w-sm h-full p-6 flex flex-col justify-between shadow-2xl z-10 overflow-y-auto">
                <div class="space-y-6">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                        <span class="font-serif font-bold text-lg uppercase tracking-widest text-black">
                            {{ $settings['web_site_name'] ?? 'TREND HUB' }}
                        </span>
                        <button @click="mobileMenuOpen = false" class="p-1.5 text-gray-400 hover:text-black">
                            <i data-lucide="x" class="w-5 h-5"></i>
                        </button>
                    </div>

                    <nav class="flex flex-col space-y-4 text-xs font-semibold uppercase tracking-[0.2em] text-neutral-800">
                        <a href="{{ route('storefront.home') }}" class="py-2 border-b border-gray-50 hover:text-black">Home</a>
                        <a href="{{ route('storefront.shop') }}" class="py-2 border-b border-gray-50 hover:text-black">All Collections</a>
                        <a href="{{ route('storefront.shop', ['tag' => 'New Arrival']) }}" class="py-2 border-b border-gray-50 hover:text-black">New Arrivals</a>
                        <a href="{{ route('storefront.shop', ['tag' => 'Best Seller']) }}" class="py-2 border-b border-gray-50 hover:text-black">Best Sellers</a>
                        <a href="{{ route('storefront.store_locator') }}" class="py-2 border-b border-gray-50 hover:text-black">Store Locator</a>
                        <a href="{{ route('storefront.wishlist') }}" class="py-2 border-b border-gray-50 hover:text-black">Wishlist (<span x-text="wishlist.length"></span>)</a>
                    </nav>
                </div>

                <div class="border-t border-gray-100 pt-6 space-y-3 text-[11px] text-gray-500">
                    <p class="font-medium text-black">Customer Support</p>
                    <p>WhatsApp: +92 {{ ltrim($settings['web_whatsapp_number'] ?? '3173340926', '0') }}</p>
                    <p>Email: {{ $settings['web_contact_email'] ?? 'trendhubstorepk1@gmail.com' }}</p>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('storefront.partials.footer')

    <!-- Side Cart Drawer -->
    @include('storefront.partials.cart-drawer')

    <!-- Quick View Modal -->
    @include('storefront.partials.quick-view')

    <!-- Search Modal -->
    <div 
        x-show="searchModalOpen" 
        x-cloak 
        class="fixed inset-0 z-50 flex items-start justify-center pt-24 bg-black/70 backdrop-blur-xs p-4"
        @keydown.escape.window="searchModalOpen = false"
    >
        <div class="bg-white w-full max-w-xl rounded-xl shadow-2xl p-6 relative animate-in fade-in zoom-in-95" @click.outside="searchModalOpen = false">
            <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                <span class="text-xs uppercase tracking-widest font-bold text-gray-400">Search Products</span>
                <button @click="searchModalOpen = false" class="text-gray-400 hover:text-black"><i data-lucide="x" class="w-5 h-5"></i></button>
            </div>
            <form action="{{ route('storefront.shop') }}" method="GET" class="pt-4 flex gap-2">
                <input 
                    type="text" 
                    name="q" 
                    placeholder="Search shirts, trousers, polos, jackets..." 
                    class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-black font-sans"
                    autofocus
                >
                <button type="submit" class="bg-black hover:bg-neutral-800 text-white px-5 py-2.5 rounded-lg text-xs uppercase font-bold tracking-wider">
                    Search
                </button>
            </form>
        </div>
    </div>

    <!-- Floating WhatsApp Button -->
    @php
        $rawWa = $settings['web_whatsapp_number'] ?? '3173340926';
        $cleanWa = preg_replace('/[^0-9]/', '', $rawWa);
        if (str_starts_with($cleanWa, '0')) {
            $cleanWa = '92' . substr($cleanWa, 1);
        } elseif (!str_starts_with($cleanWa, '92')) {
            $cleanWa = '92' . $cleanWa;
        }
    @endphp
    <a 
        href="https://wa.me/{{ $cleanWa }}?text={{ urlencode('Assalam-o-Alaikum TrendHub, I am interested in your menswear collection.') }}" 
        target="_blank"
        rel="noopener noreferrer"
        class="fixed bottom-6 right-6 z-40 bg-[#25D366] hover:bg-[#20ba5a] text-white p-3.5 rounded-full shadow-2xl transition-all duration-300 hover:scale-110 flex items-center justify-center group"
        aria-label="Contact us on WhatsApp"
    >
        <i data-lucide="message-circle" class="w-6 h-6 fill-white stroke-none"></i>
        <span class="max-w-0 overflow-hidden whitespace-nowrap group-hover:max-w-xs transition-all duration-500 text-xs font-bold font-sans pl-0 group-hover:pl-2">
            Chat with us
        </span>
    </a>

    <!-- Global Storefront Alpine App State -->
    <script>
        function storefrontApp() {
            return {
                mobileMenuOpen: false,
                searchModalOpen: false,
                isCartOpen: false,
                cart: [],
                wishlist: [],
                quickView: {
                    isOpen: false,
                    product: null,
                    activeImg: '',
                    selectedSize: '',
                    selectedColor: '',
                    qty: 1
                },

                initApp() {
                    // Load Cart from localStorage
                    try {
                        const savedCart = localStorage.getItem('th_cart');
                        if (savedCart) this.cart = JSON.parse(savedCart);
                    } catch (e) {
                        this.cart = [];
                    }

                    // Load Wishlist from localStorage
                    try {
                        const savedWish = localStorage.getItem('th_wishlist');
                        if (savedWish) this.wishlist = JSON.parse(savedWish);
                    } catch (e) {
                        this.wishlist = [];
                    }

                    // Re-render icons on mount
                    this.$nextTick(() => {
                        if (window.lucide) window.lucide.createIcons();
                    });
                },

                saveCart() {
                    localStorage.setItem('th_cart', JSON.stringify(this.cart));
                },

                get cartCount() {
                    return this.cart.reduce((sum, item) => sum + (parseInt(item.quantity) || 1), 0);
                },

                get cartSubtotal() {
                    return this.cart.reduce((sum, item) => sum + ((parseFloat(item.price) || 0) * (parseInt(item.quantity) || 1)), 0);
                },

                addToCart(product, quantity = 1, size = null, color = null) {
                    const price = parseFloat(product.final_price || product.web_sale_price || product.sale_price_per_piece || 0);
                    const image = product.display_image || product.image || '/placeholders/outfitter_prod_1.jpg';
                    const name = product.item_name || 'Apparel Item';
                    const id = product.id;

                    const existingIndex = this.cart.findIndex(i => 
                        i.id === id && i.selectedSize === size && i.selectedColor === color
                    );

                    if (existingIndex > -1) {
                        this.cart[existingIndex].quantity += parseInt(quantity) || 1;
                    } else {
                        this.cart.push({
                            id: id,
                            name: name,
                            price: price,
                            image: image,
                            quantity: parseInt(quantity) || 1,
                            selectedSize: size || '',
                            selectedColor: color || ''
                        });
                    }

                    this.saveCart();
                    this.isCartOpen = true;
                    this.$nextTick(() => {
                        if (window.lucide) window.lucide.createIcons();
                    });
                },

                updateCartQty(index, newQty) {
                    if (newQty <= 0) {
                        this.removeFromCart(index);
                    } else {
                        this.cart[index].quantity = newQty;
                        this.saveCart();
                    }
                },

                removeFromCart(index) {
                    this.cart.splice(index, 1);
                    this.saveCart();
                },

                toggleWishlist(productId) {
                    const id = parseInt(productId);
                    const idx = this.wishlist.indexOf(id);
                    if (idx > -1) {
                        this.wishlist.splice(idx, 1);
                    } else {
                        this.wishlist.push(id);
                    }
                    localStorage.setItem('th_wishlist', JSON.stringify(this.wishlist));
                },

                isInWishlist(productId) {
                    return this.wishlist.includes(parseInt(productId));
                },

                openQuickView(productData) {
                    this.quickView.product = productData;
                    this.quickView.activeImg = productData.display_image || (productData.gallery_images && productData.gallery_images[0]) || '';
                    this.quickView.selectedSize = (productData.parsed_sizes && productData.parsed_sizes[0]) || '';
                    this.quickView.selectedColor = (productData.parsed_colors && productData.parsed_colors[0]) || '';
                    this.quickView.qty = 1;
                    this.quickView.isOpen = true;

                    this.$nextTick(() => {
                        if (window.lucide) window.lucide.createIcons();
                    });
                },

                closeQuickView() {
                    this.quickView.isOpen = false;
                }
            }
        }
    </script>

    @stack('scripts')
</body>
</html>
