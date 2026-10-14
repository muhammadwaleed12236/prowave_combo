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

    // Fabric/texture tag
    $nameLower = strtolower($product->item_name);
    $fabricTag = 'Texture';
    if (str_contains($nameLower, 'polo')) $fabricTag = 'Micro Zig Zag';
    elseif (str_contains($nameLower, 'shirt')) $fabricTag = 'Seer Sucker Lycra';
    elseif (str_contains($nameLower, 'jacket')) $fabricTag = 'Drop Needle Jersey';
    elseif (str_contains($nameLower, 'trouser')) $fabricTag = 'Stretch Fit';
    elseif (str_contains($nameLower, 'cargo')) $fabricTag = 'Neoprene';
@endphp

<div class="group w-full flex flex-col relative overflow-hidden bg-white select-none transition-all duration-500 hover:-translate-y-1 hover:shadow-xl rounded-[2px] border border-transparent hover:border-gray-100">
    <!-- Image & Badges Container -->
    <div class="relative aspect-[3/4] overflow-hidden bg-gray-50 block">
        
        <!-- Quarter Circle Sale Tag -->
        @if($product->discount_percent > 0)
            <div class="absolute top-0 left-0 w-9 h-9 bg-[#7a0f12] text-white rounded-br-full z-10 pointer-events-none shadow-sm">
                <span class="absolute top-[11px] left-[5px] text-[9px] font-sans font-bold tracking-tighter leading-none block">
                    -{{ $product->discount_percent }}%
                </span>
            </div>
        @endif

        <!-- Wishlist Button (Top Right) -->
        <button 
            @click.stop="toggleWishlist({{ $product->id }})" 
            class="absolute top-2.5 right-2.5 z-10 w-7 h-7 rounded-full bg-white/90 hover:bg-white text-neutral-800 flex items-center justify-center transition-all shadow-sm cursor-pointer hover:scale-110"
            aria-label="Wishlist"
        >
            <i 
                data-lucide="heart" 
                class="w-3.5 h-3.5 transition-colors"
                :class="isInWishlist({{ $product->id }}) ? 'fill-red-600 text-red-600' : 'text-neutral-700'"
            ></i>
        </button>

        <!-- Out of Stock Badge -->
        @if($product->total_stock !== null && $product->total_stock <= 0)
            <div class="absolute top-2.5 left-2.5 z-10 pointer-events-none">
                <span class="bg-[#222222]/95 backdrop-blur-[1px] text-white text-[9px] uppercase tracking-wider px-2 py-1 font-sans font-bold shadow-sm">
                    Out of Stock
                </span>
            </div>
        @endif

        <!-- Product Image Link -->
        <a href="{{ route('storefront.product', $product->id) }}" class="w-full h-full block">
            <img 
                src="{{ $product->display_image }}" 
                alt="{{ $product->item_name }}" 
                loading="lazy"
                class="w-full h-full object-cover transition-all duration-700 ease-out group-hover:scale-105 {{ $product->total_stock !== null && $product->total_stock <= 0 ? 'opacity-60 grayscale-[40%]' : '' }}"
                onerror="this.src='/placeholders/outfitter_prod_1.jpg'"
            >
        </a>

        <!-- Hover Actions Bar (Add to Cart & Quick View Eye) -->
        <div class="absolute bottom-3 left-3 right-3 z-10 flex bg-white shadow-md border border-neutral-100 translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300 ease-out">
            @if($product->total_stock !== null && $product->total_stock <= 0)
                <div class="flex-1 bg-neutral-50 text-neutral-400 text-[10px] sm:text-xs font-sans font-bold tracking-wider uppercase flex items-center justify-center py-1.5 px-2 select-none">
                    Out of Stock
                </div>
            @else
                <button 
                    @click.prevent.stop="addToCart({{ $productJson }}, 1, '{{ $product->parsed_sizes[0] ?? '' }}', '{{ $product->parsed_colors[0] ?? '' }}')"
                    class="flex-1 bg-white hover:bg-neutral-900 hover:text-white text-neutral-900 text-[10px] sm:text-xs font-sans font-bold tracking-wider uppercase transition-colors duration-300 py-1.5 px-2 flex items-center justify-center cursor-pointer"
                >
                    Add to Cart
                </button>
            @endif

            <div class="w-[1px] bg-neutral-200"></div>

            <button 
                @click.prevent.stop="openQuickView({{ $productJson }})"
                class="w-9 hover:bg-neutral-900 hover:text-white text-neutral-900 flex items-center justify-center transition-colors duration-300 cursor-pointer"
                aria-label="Quick View"
            >
                <i data-lucide="eye" class="w-4 h-4"></i>
            </button>
        </div>

        <!-- Fabric Tag (Bottom Left Overlay) -->
        <div class="absolute bottom-0 left-0 bg-[#dcdcdc]/70 text-neutral-800 text-[10px] font-sans font-medium py-1 px-3.5 tracking-wide select-none pointer-events-none transition-opacity duration-300 group-hover:opacity-0">
            {{ $fabricTag }}
        </div>
    </div>

    <!-- Product Text Details -->
    <div class="pt-4 pb-2 text-center space-y-1.5 px-2">
        <a 
            href="{{ route('storefront.product', $product->id) }}" 
            class="text-xs sm:text-[13px] font-sans uppercase font-semibold text-neutral-800 hover:text-black transition-colors tracking-wide min-h-[32px] sm:min-h-[40px] flex items-center justify-center line-clamp-2"
        >
            {{ $product->item_name }}
        </a>

        <!-- Pricing -->
        <div class="flex justify-center items-baseline gap-2 text-[10px] sm:text-xs font-sans">
            @if($product->discount_percent > 0)
                <span class="text-gray-400 line-through font-light">
                    PKR {{ number_format(round($product->sale_price_per_piece ?: 0)) }}
                </span>
            @endif
            <span class="text-black font-bold">
                PKR {{ number_format(round($product->final_price)) }}
            </span>
        </div>
    </div>
</div>
