@php
    $productJson = json_encode([
        'id' => $product->id,
        'item_name' => $product->item_name,
        'item_code' => $product->item_code,
        'final_price' => $product->final_price,
        'sale_price_per_piece' => $product->sale_price_per_piece,
        'discount_percent' => $product->discount_percent,
        'display_image' => $product->display_image,
        'gallery_images' => $product->gallery_images,
        'category_relation' => $product->category_relation ? ['name' => $product->category_relation->name] : null,
        'parsed_sizes' => $product->parsed_sizes,
        'parsed_colors' => $product->parsed_colors,
        'total_stock' => $product->total_stock,
    ]);

    // Deterministic review count & rating based on product id
    $rating = 4.7 + (($product->id % 3) * 0.1);
    $reviewCount = 85 + (($product->id * 17) % 150);
@endphp

<div class="group w-full flex flex-col bg-white rounded-md border border-gray-100 hover:border-gray-200 hover:shadow-lg transition-all duration-300 p-2 sm:p-2.5 select-none">
    <!-- Image & Badges Container -->
    <div class="relative aspect-[3/4] overflow-hidden rounded bg-gray-50 block">
        
        <!-- Sale Discount Badge -->
        @if($product->discount_percent > 0)
            <div class="absolute top-2 left-2 z-10 bg-red-600 text-white text-[9px] font-sans font-bold px-1.5 py-0.5 rounded shadow-xs">
                -{{ $product->discount_percent }}%
            </div>
        @endif

        <!-- Wishlist Button (Top Right) -->
        <button 
            @click.stop="toggleWishlist({{ $product->id }})" 
            class="absolute top-2 right-2 z-10 w-7 h-7 rounded-full bg-white/90 hover:bg-white text-neutral-700 flex items-center justify-center transition-all shadow-xs cursor-pointer hover:scale-110"
            aria-label="Wishlist"
        >
            <i 
                data-lucide="heart" 
                class="w-3.5 h-3.5 transition-colors"
                :class="isInWishlist({{ $product->id }}) ? 'fill-red-600 text-red-600' : 'text-neutral-600'"
            ></i>
        </button>

        <!-- Product Image Link -->
        <a href="{{ route('storefront.product', $product->id) }}" class="w-full h-full block">
            <img 
                src="{{ asset($product->display_image) }}" 
                alt="{{ $product->item_name }}" 
                loading="lazy"
                class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500 ease-out"
                x-on:error="$event.target.src = '/placeholders/outfitter_prod_1.jpg'"
            >
        </a>

        <!-- Quick View Eye Button (Hover) -->
        <button 
            @click.prevent.stop="openQuickView({{ $productJson }})"
            class="absolute bottom-2 right-2 z-10 w-7 h-7 rounded-full bg-white/90 hover:bg-black hover:text-white text-neutral-800 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all shadow-xs cursor-pointer"
            aria-label="Quick View"
            title="Quick View"
        >
            <i data-lucide="eye" class="w-3.5 h-3.5"></i>
        </button>
    </div>

    <!-- Product Text Details (Reference Match) -->
    <div class="pt-2.5 pb-1 flex-1 flex flex-col justify-between space-y-1.5">
        <div>
            <a 
                href="{{ route('storefront.product', $product->id) }}" 
                class="text-xs sm:text-[13px] font-sans font-medium text-neutral-900 hover:text-[#b89758] transition-colors line-clamp-1 block"
                title="{{ $product->item_name }}"
            >
                {{ $product->item_name }}
            </a>
            <span class="text-[10px] text-gray-400 font-sans block">
                {{ $product->category_relation ? $product->category_relation->name : 'Men\'s Fashion' }}
            </span>
        </div>

        <!-- Star Reviews -->
        <div class="flex items-center gap-1 text-[10px] text-gray-500 font-sans">
            <div class="flex text-[#b89758]">
                <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
            </div>
            <span class="font-bold text-neutral-700">{{ number_format($rating, 1) }}</span>
            <span class="text-gray-400">({{ $reviewCount }})</span>
        </div>

        <!-- Price -->
        <div class="flex items-baseline gap-2 pt-0.5">
            <span class="text-sm font-bold text-neutral-900 font-sans">
                Rs. {{ number_format(round($product->final_price)) }}
            </span>
            @if($product->discount_percent > 0)
                <span class="text-[11px] text-gray-400 line-through font-light font-sans">
                    Rs. {{ number_format(round($product->sale_price_per_piece ?: 0)) }}
                </span>
            @endif
        </div>

        <!-- Add to Cart Full-Width Solid Black Button (Reference Match) -->
        <div class="pt-1.5">
            <button 
                @click.prevent.stop="addToCart({{ $productJson }}, 1, '{{ $product->parsed_sizes[0] ?? '' }}', '{{ $product->parsed_colors[0] ?? '' }}')"
                class="w-full bg-neutral-950 hover:bg-[#b89758] text-white text-[11px] font-sans font-bold py-2 px-3 rounded flex items-center justify-center gap-1.5 transition-colors duration-200 cursor-pointer shadow-xs active:scale-95"
            >
                <i data-lucide="shopping-cart" class="w-3.5 h-3.5"></i>
                <span>Add to Cart</span>
            </button>
        </div>
    </div>
</div>
