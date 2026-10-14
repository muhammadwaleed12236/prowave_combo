@extends('storefront.layout')

@section('title', $product->item_name . ' | ' . ($settings['web_site_name'] ?? 'TrendHub'))
@section('meta_description', $product->description ?: 'Explore ' . $product->item_name . ' designed by ' . ($settings['web_site_name'] ?? 'TrendHub'))

@section('content')
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
@endphp

<div class="bg-white" x-data="{
    activeImg: '{{ $product->display_image }}',
    selectedSize: '{{ $product->parsed_sizes[0] ?? '' }}',
    selectedColor: '{{ $product->parsed_colors[0] ?? '' }}',
    quantity: 1
}">
    <!-- Breadcrumbs -->
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-5 border-b border-gray-100 text-xs font-sans text-gray-400 uppercase tracking-widest flex items-center gap-2">
        <a href="{{ route('storefront.home') }}" class="hover:text-black">Home</a>
        <span>/</span>
        <a href="{{ route('storefront.shop') }}" class="hover:text-black">Shop</a>
        @if($product->category_relation)
            <span>/</span>
            <a href="{{ route('storefront.shop', ['category' => $product->category_relation->name]) }}" class="hover:text-black">{{ $product->category_relation->name }}</a>
        @endif
        <span>/</span>
        <span class="text-neutral-900 font-bold truncate max-w-xs">{{ $product->item_name }}</span>
    </div>

    <!-- Product Details Section -->
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-10 lg:py-16">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-16">
            
            <!-- Left: Gallery -->
            <div class="space-y-4">
                <!-- Main Image Box -->
                <div class="aspect-[3/4] w-full max-w-lg mx-auto bg-gray-50 border border-gray-100 rounded-2xl overflow-hidden shadow-sm relative group">
                    <img 
                        :src="activeImg" 
                        alt="{{ $product->item_name }}" 
                        class="w-full h-full object-cover transition-all duration-500"
                        onerror="this.src='/placeholders/outfitter_prod_1.jpg'"
                    >
                    @if($product->discount_percent > 0)
                        <div class="absolute top-4 left-4 bg-[#7a0f12] text-white text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded shadow-xs">
                            -{{ $product->discount_percent }}% OFF
                        </div>
                    @endif
                </div>

                <!-- Thumbnails Strip -->
                @if(count($product->gallery_images) > 1)
                    <div class="flex gap-3 justify-center overflow-x-auto py-2 scrollbar-none">
                        @foreach($product->gallery_images as $gImg)
                            <button 
                                @click="activeImg = '{{ $gImg }}'" 
                                class="w-16 h-20 border rounded-xl overflow-hidden shrink-0 transition-all cursor-pointer"
                                :class="activeImg === '{{ $gImg }}' ? 'border-black ring-2 ring-black scale-95 shadow-sm' : 'border-gray-200 opacity-70 hover:opacity-100'"
                            >
                                <img src="{{ $gImg }}" alt="Gallery" class="w-full h-full object-cover" onerror="this.src='/placeholders/outfitter_prod_1.jpg'">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Right: Product Info & Actions -->
            <div class="space-y-6 font-sans">
                <div>
                    <span class="text-xs uppercase tracking-[0.25em] text-gray-400 font-bold block mb-1">
                        {{ $product->category_relation ? $product->category_relation->name : 'MENSWEAR' }}
                    </span>
                    <h1 class="font-serif text-2xl sm:text-3xl lg:text-4xl uppercase tracking-wide font-normal text-neutral-900 leading-tight">
                        {{ $product->item_name }}
                    </h1>
                    <div class="flex items-center gap-4 pt-2 text-xs text-gray-400 font-mono">
                        @if($product->item_code) <span>SKU: {{ $product->item_code }}</span> @endif
                        <span>&bull;</span>
                        <span class="text-emerald-700 font-semibold font-sans uppercase text-[10px]">In Stock & Ready to Ship</span>
                    </div>
                </div>

                <!-- Price -->
                <div class="border-t border-b border-gray-100 py-4 flex items-baseline gap-3">
                    <span class="text-2xl sm:text-3xl font-bold text-black">
                        PKR {{ number_format(round($product->final_price)) }}
                    </span>
                    @if($product->discount_percent > 0)
                        <span class="text-base text-gray-400 line-through font-light">
                            PKR {{ number_format(round($product->sale_price_per_piece ?: 0)) }}
                        </span>
                        <span class="text-xs font-bold text-white bg-[#7a0f12] px-2 py-0.5 rounded uppercase tracking-wider">
                            SAVE {{ $product->discount_percent }}%
                        </span>
                    @endif
                </div>

                <!-- Description -->
                <div class="text-xs sm:text-sm text-neutral-600 leading-relaxed font-light space-y-2">
                    <p>
                        {{ $product->description ?: 'Designed as part of our premium modern luxury apparel collection, this piece stands out with premium stitching and refined cuts. Crafted for all-day comfort and effortless styling.' }}
                    </p>
                </div>

                <!-- Size Selector -->
                @if(count($product->parsed_sizes) > 0)
                    <div class="space-y-2 pt-2">
                        <div class="flex justify-between items-center text-xs">
                            <span class="font-bold uppercase tracking-wider text-black">
                                Select Size: <span class="text-neutral-500 font-semibold" x-text="selectedSize"></span>
                            </span>
                            <span class="text-[10px] uppercase text-gray-400 tracking-wider">Regular Fit</span>
                        </div>
                        <div class="flex gap-2 flex-wrap">
                            @foreach($product->parsed_sizes as $sz)
                                <button 
                                    @click="selectedSize = '{{ $sz }}'" 
                                    class="px-5 py-2.5 text-xs font-semibold tracking-wider transition-all uppercase rounded-full border cursor-pointer"
                                    :class="selectedSize === '{{ $sz }}' ? 'border-black bg-black text-white shadow-sm' : 'border-gray-200 text-gray-600 hover:border-black bg-white'"
                                >
                                    {{ $sz }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Color Selector -->
                @if(count($product->parsed_colors) > 0)
                    <div class="space-y-2 pt-2">
                        <span class="text-xs font-bold uppercase tracking-wider text-black block">
                            Select Color: <span class="text-neutral-500 font-semibold capitalize" x-text="selectedColor"></span>
                        </span>
                        <div class="flex gap-2 flex-wrap">
                            @foreach($product->parsed_colors as $col)
                                <button 
                                    @click="selectedColor = '{{ $col }}'" 
                                    class="px-5 py-2.5 text-xs font-semibold tracking-wider transition-all uppercase rounded-full border cursor-pointer"
                                    :class="selectedColor === '{{ $col }}' ? 'border-black bg-black text-white shadow-sm' : 'border-gray-200 text-gray-600 hover:border-black bg-white'"
                                >
                                    {{ $col }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Quantity & Action Buttons -->
                <div class="space-y-4 pt-4">
                    <div class="flex items-center gap-4">
                        <span class="text-xs font-bold uppercase tracking-wider text-black">Quantity</span>
                        <div class="flex items-center border border-gray-200 rounded-full py-1 px-2 w-max">
                            <button 
                                @click="quantity = Math.max(1, quantity - 1)" 
                                class="px-2.5 text-gray-400 hover:text-black font-bold text-sm"
                            >-</button>
                            <span class="px-3 text-sm text-black font-bold font-mono min-w-[24px] text-center" x-text="quantity"></span>
                            <button 
                                @click="quantity++" 
                                class="px-2.5 text-gray-400 hover:text-black font-bold text-sm"
                            >+</button>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2">
                        <button 
                            @click="addToCart({{ $productJson }}, quantity, selectedSize, selectedColor)"
                            class="w-full bg-white hover:bg-neutral-900 hover:text-white text-neutral-900 text-xs font-bold tracking-[0.2em] uppercase transition-colors duration-300 py-3.5 border border-black rounded-xl cursor-pointer shadow-xs"
                        >
                            Add to Cart
                        </button>
                        <button 
                            @click="addToCart({{ $productJson }}, quantity, selectedSize, selectedColor); window.location.href = '{{ route('storefront.checkout') }}'"
                            class="w-full bg-black hover:bg-neutral-800 text-white text-xs font-bold tracking-[0.2em] uppercase transition-colors duration-300 py-3.5 rounded-xl cursor-pointer shadow-md"
                        >
                            Buy It Now
                        </button>
                    </div>

                    <!-- Direct WhatsApp Order -->
                    @php
                        $rawPh = $settings['web_whatsapp_number'] ?? '3173340926';
                        $cleanPh = preg_replace('/[^0-9]/', '', $rawPh);
                        if (!str_starts_with($cleanPh, '92')) $cleanPh = '92' . ltrim($cleanPh, '0');
                        $waText = "Assalam-o-Alaikum, I want to order:\nProduct: {$product->item_name}\nPrice: PKR " . number_format($product->final_price) . "\nLink: " . url()->current();
                    @endphp
                    <a 
                        href="https://wa.me/{{ $cleanPh }}?text={{ urlencode($waText) }}" 
                        target="_blank"
                        class="w-full border border-emerald-600 text-emerald-700 hover:bg-emerald-50 text-xs font-bold tracking-wider uppercase py-3 rounded-xl flex items-center justify-center gap-2 transition-colors cursor-pointer"
                    >
                        <i data-lucide="message-circle" class="w-4 h-4 fill-emerald-600 stroke-none"></i>
                        Order via WhatsApp
                    </a>
                </div>

                <!-- Shipping & Return Trust Badges -->
                <div class="border-t border-gray-100 pt-6 space-y-3 text-xs text-gray-500 font-sans">
                    <div class="flex items-center gap-3">
                        <i data-lucide="truck" class="w-4 h-4 text-black shrink-0"></i>
                        <span>Dispatched within 24 hours via Trax / Call Courier</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <i data-lucide="rotate-ccw" class="w-4 h-4 text-black shrink-0"></i>
                        <span>7-Day Hassle-Free Size Exchange Policy</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <i data-lucide="shield-check" class="w-4 h-4 text-black shrink-0"></i>
                        <span>100% Genuine Luxury Menswear Guarantee</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products Section -->
        @if(count($relatedProducts) > 0)
            <div class="pt-20 border-t border-gray-100 mt-16">
                <div class="text-center mb-10">
                    <span class="text-[10px] font-sans font-bold tracking-[0.25em] uppercase text-gray-400">YOU MAY ALSO ADMIRE</span>
                    <h3 class="font-serif text-2xl sm:text-3xl uppercase tracking-wide font-normal text-neutral-900 mt-1">
                        Related Menswear
                    </h3>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 sm:gap-6">
                    @foreach($relatedProducts as $rel)
                        @include('storefront.partials.product-card', ['product' => $rel])
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
