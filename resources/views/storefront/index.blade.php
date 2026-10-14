@extends('storefront.layout')

@section('title', ($settings['web_site_name'] ?? 'TrendHub') . " | Elevate Your Style — Men's Wear")

@section('content')

<!-- 1. HERO BANNER (REFERENCE MATCH: EDITORIAL LUXURY MENSWEAR) -->
<section class="relative w-full bg-[#0a0a0a] overflow-hidden min-h-[520px] lg:min-h-[580px] flex items-center">
    <!-- Background Image / Video with Split Overlay -->
    <div class="absolute inset-0 z-0">
        @php
            $heroImg = !empty($settings['web_home_hero_image']) ? asset($settings['web_home_hero_image']) : asset('placeholders/outfitter_prod_5.jpg');
        @endphp
        <img 
            src="{{ $heroImg }}" 
            alt="Hero Menswear Model" 
            class="w-full h-full object-cover object-right md:object-center brightness-[0.7] contrast-[1.05]"
            x-on:error="$event.target.src = '/placeholders/outfitter_prod_5.jpg'"
        >
        <!-- Luxury Left Gradient -->
        <div class="absolute inset-0 bg-gradient-to-r from-black via-black/80 md:via-black/60 to-transparent z-10"></div>
    </div>

    <!-- Hero Content Container -->
    <div class="relative z-20 max-w-[1400px] mx-auto w-full px-6 sm:px-10 lg:px-12 py-16 flex flex-col md:flex-row items-center justify-between gap-10">
        
        <!-- Left Editorial Text -->
        <div class="max-w-[620px] space-y-5 text-left">
            <span 
                data-aos="fade-right"
                class="text-[11px] sm:text-xs font-sans font-bold uppercase tracking-[0.25em] text-[#c5a880] block"
            >
                PREMIUM MEN'S COLLECTION
            </span>

            <h1 
                data-aos="fade-up" 
                data-aos-duration="700"
                class="font-serif text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-normal tracking-tight text-white leading-tight uppercase"
            >
                ELEVATE<br>
                <span class="text-[#c5a880] font-light">YOUR STYLE</span>
            </h1>

            <p 
                data-aos="fade-up" 
                data-aos-delay="150"
                class="text-xs sm:text-sm md:text-base text-gray-300 font-sans font-light leading-relaxed max-w-[500px]"
            >
                Discover modern fits, premium fabrics and timeless menswear for every occasion.
            </p>

            <div data-aos="fade-up" data-aos-delay="250" class="pt-2">
                <a 
                    href="{{ route('storefront.shop') }}" 
                    class="inline-flex items-center gap-2 bg-[#b89758] hover:bg-[#a6864a] text-black font-sans font-bold text-xs uppercase tracking-widest px-8 py-3.5 rounded-[2px] transition-all duration-300 shadow-md hover:scale-105 active:scale-95"
                >
                    <span>SHOP NOW</span>
                    <span>&rarr;</span>
                </a>
            </div>

            <!-- 3 Trust Badges Below Button -->
            <div 
                data-aos="fade-up" 
                data-aos-delay="350"
                class="pt-4 flex items-center gap-6 text-xs text-gray-300 font-sans"
            >
                <div class="flex items-center gap-2">
                    <span class="text-[#c5a880]">🛡️</span>
                    <span>Premium Quality</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-[#c5a880]">✂️</span>
                    <span>Trendy Designs</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-[#c5a880]">⚙️</span>
                    <span>Comfort Fit</span>
                </div>
            </div>
        </div>

        <!-- Right Side Cursive Script Overlay -->
        <div 
            data-aos="fade-left" 
            data-aos-duration="1000"
            class="hidden md:block select-none"
        >
            <span class="font-serif italic text-4xl lg:text-6xl text-[#c5a880]/70 tracking-wide drop-shadow-md">
                Style Redefined
            </span>
        </div>
    </div>
</section>

<!-- 2. CIRCULAR CATEGORY NAVIGATION ROW (REFERENCE MATCH) -->
<section class="py-12 bg-white border-b border-gray-100 select-none">
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-3 sm:grid-cols-6 gap-6 sm:gap-8 text-center">
            
            <!-- Category 1: Trousers -->
            <a href="{{ route('storefront.shop', ['category' => 'TROUSERS']) }}" class="flex flex-col items-center group">
                <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full overflow-hidden bg-gray-50 border border-gray-200 group-hover:border-[#b89758] transition-all duration-300 shadow-xs group-hover:scale-105 p-1">
                    <img src="{{ asset('placeholders/product_4_main.jpg') }}" alt="Trousers" class="w-full h-full object-cover rounded-full" x-on:error="$event.target.src = '/placeholders/outfitter_prod_4.jpg'">
                </div>
                <h4 class="mt-3 text-xs font-sans font-bold uppercase tracking-wider text-neutral-900 group-hover:text-[#b89758] transition-colors">TROUSERS</h4>
                <span class="text-[10px] text-gray-400 font-sans group-hover:underline">Shop Now &rarr;</span>
            </a>

            <!-- Category 2: Shirts -->
            <a href="{{ route('storefront.shop', ['category' => 'SHIRTS']) }}" class="flex flex-col items-center group">
                <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full overflow-hidden bg-gray-50 border border-gray-200 group-hover:border-[#b89758] transition-all duration-300 shadow-xs group-hover:scale-105 p-1">
                    <img src="{{ asset('placeholders/product_1_main.jpg') }}" alt="Shirts" class="w-full h-full object-cover rounded-full" x-on:error="$event.target.src = '/placeholders/outfitter_prod_1.jpg'">
                </div>
                <h4 class="mt-3 text-xs font-sans font-bold uppercase tracking-wider text-neutral-900 group-hover:text-[#b89758] transition-colors">SHIRTS</h4>
                <span class="text-[10px] text-gray-400 font-sans group-hover:underline">Shop Now &rarr;</span>
            </a>

            <!-- Category 3: T-Shirts -->
            <a href="{{ route('storefront.shop', ['category' => 'T-SHIRTS']) }}" class="flex flex-col items-center group">
                <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full overflow-hidden bg-gray-50 border border-gray-200 group-hover:border-[#b89758] transition-all duration-300 shadow-xs group-hover:scale-105 p-1">
                    <img src="{{ asset('placeholders/product_2_main.jpg') }}" alt="T-Shirts" class="w-full h-full object-cover rounded-full" x-on:error="$event.target.src = '/placeholders/outfitter_prod_2.jpg'">
                </div>
                <h4 class="mt-3 text-xs font-sans font-bold uppercase tracking-wider text-neutral-900 group-hover:text-[#b89758] transition-colors">T-SHIRTS</h4>
                <span class="text-[10px] text-gray-400 font-sans group-hover:underline">Shop Now &rarr;</span>
            </a>

            <!-- Category 4: Jeans -->
            <a href="{{ route('storefront.shop', ['category' => 'JEANS']) }}" class="flex flex-col items-center group">
                <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full overflow-hidden bg-gray-50 border border-gray-200 group-hover:border-[#b89758] transition-all duration-300 shadow-xs group-hover:scale-105 p-1">
                    <img src="{{ asset('placeholders/product_3_main.jpg') }}" alt="Jeans" class="w-full h-full object-cover rounded-full" x-on:error="$event.target.src = '/placeholders/outfitter_prod_3.jpg'">
                </div>
                <h4 class="mt-3 text-xs font-sans font-bold uppercase tracking-wider text-neutral-900 group-hover:text-[#b89758] transition-colors">JEANS</h4>
                <span class="text-[10px] text-gray-400 font-sans group-hover:underline">Shop Now &rarr;</span>
            </a>

            <!-- Category 5: New Arrivals -->
            <a href="{{ route('storefront.shop', ['tag' => 'New Arrival']) }}" class="flex flex-col items-center group">
                <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full overflow-hidden bg-gray-50 border border-gray-200 group-hover:border-[#b89758] transition-all duration-300 shadow-xs group-hover:scale-105 p-1">
                    <img src="{{ asset('placeholders/product_5_main.jpg') }}" alt="New Arrivals" class="w-full h-full object-cover rounded-full" x-on:error="$event.target.src = '/placeholders/outfitter_prod_7.jpg'">
                </div>
                <h4 class="mt-3 text-xs font-sans font-bold uppercase tracking-wider text-neutral-900 group-hover:text-[#b89758] transition-colors">NEW ARRIVALS</h4>
                <span class="text-[10px] text-gray-400 font-sans group-hover:underline">Shop Now &rarr;</span>
            </a>

            <!-- Category 6: Sale (% Badge) -->
            <a href="{{ route('storefront.shop', ['tag' => 'Sale']) }}" class="flex flex-col items-center group">
                <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-red-600 text-white flex items-center justify-center font-serif text-3xl font-black shadow-xs group-hover:scale-105 transition-all duration-300">
                    %
                </div>
                <h4 class="mt-3 text-xs font-sans font-bold uppercase tracking-wider text-red-600 group-hover:text-red-700 transition-colors">SALE</h4>
                <span class="text-[10px] text-gray-400 font-sans group-hover:underline">Shop Now &rarr;</span>
            </a>

        </div>
    </div>
</section>

<!-- 3. NEW ARRIVALS (REFERENCE MATCH: TABS + 6-COLUMN GRID) -->
<section class="py-14 bg-white border-b border-gray-100" x-data="{
    activeTab: 'ALL'
}">
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        
        <!-- Header & Category Filter Tabs -->
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 pb-2 border-b border-gray-100">
            <!-- Title with Horizontal Gold Line -->
            <div class="flex items-center gap-3">
                <h2 class="font-serif text-2xl sm:text-3xl font-normal uppercase tracking-wide text-neutral-900">
                    NEW ARRIVALS
                </h2>
                <div class="w-12 h-0.5 bg-[#b89758]"></div>
            </div>

            <!-- Tabs on Right -->
            <div class="flex items-center gap-2 sm:gap-4 overflow-x-auto scrollbar-none text-xs font-sans font-semibold">
                <button 
                    @click="activeTab = 'ALL'"
                    class="pb-1 transition-colors cursor-pointer"
                    :class="activeTab === 'ALL' ? 'text-black font-bold border-b-2 border-black' : 'text-gray-400 hover:text-black'"
                >
                    All
                </button>
                <button 
                    @click="activeTab = 'TROUSERS'"
                    class="pb-1 transition-colors cursor-pointer"
                    :class="activeTab === 'TROUSERS' ? 'text-black font-bold border-b-2 border-black' : 'text-gray-400 hover:text-black'"
                >
                    Trousers
                </button>
                <button 
                    @click="activeTab = 'SHIRTS'"
                    class="pb-1 transition-colors cursor-pointer"
                    :class="activeTab === 'SHIRTS' ? 'text-black font-bold border-b-2 border-black' : 'text-gray-400 hover:text-black'"
                >
                    Shirts
                </button>
                <button 
                    @click="activeTab = 'T-SHIRTS'"
                    class="pb-1 transition-colors cursor-pointer"
                    :class="activeTab === 'T-SHIRTS' ? 'text-black font-bold border-b-2 border-black' : 'text-gray-400 hover:text-black'"
                >
                    T-Shirts
                </button>
                <button 
                    @click="activeTab = 'JEANS'"
                    class="pb-1 transition-colors cursor-pointer"
                    :class="activeTab === 'JEANS' ? 'text-black font-bold border-b-2 border-black' : 'text-gray-400 hover:text-black'"
                >
                    Jeans
                </button>
                <a 
                    href="{{ route('storefront.shop', ['tag' => 'New Arrival']) }}" 
                    class="ml-2 border border-gray-300 hover:border-black text-neutral-800 text-[11px] px-3 py-1 rounded-[2px] transition-colors whitespace-nowrap"
                >
                    View All &rarr;
                </a>
            </div>
        </div>

        <!-- 6-Column Responsive Product Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3 sm:gap-4">
            @foreach($allProducts->take(12) as $product)
                @php
                    $catName = strtoupper($product->category_relation ? $product->category_relation->name : '');
                    $itemName = strtoupper($product->item_name);
                @endphp
                <div 
                    x-show="activeTab === 'ALL' || '{{ $catName }}' === activeTab || '{{ $catName }}'.includes(activeTab) || '{{ $itemName }}'.includes(activeTab)"
                    x-transition
                >
                    @include('storefront.partials.product-card', ['product' => $product])
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- 4. TWO PROMOTIONAL SPLIT BANNERS (REFERENCE MATCH: SHIRTS & TROUSERS) -->
<section class="py-10 bg-white">
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 gap-6">
        
        <!-- Banner 1 (Left - Beige / Light Shirts Collection) -->
        <div class="relative bg-[#f4efe8] rounded overflow-hidden min-h-[220px] sm:min-h-[260px] flex items-center p-6 sm:p-10 group">
            <div class="relative z-10 max-w-[280px] space-y-2">
                <span class="text-[10px] font-sans font-bold tracking-widest uppercase text-[#b89758] block">
                    CLASSIC • MODERN • TIMELESS
                </span>
                <h3 class="font-serif text-2xl sm:text-3xl font-normal uppercase text-neutral-900 leading-tight">
                    PREMIUM SHIRTS COLLECTION
                </h3>
                <div class="pt-3">
                    <a 
                        href="{{ route('storefront.shop', ['category' => 'SHIRTS']) }}" 
                        class="inline-flex items-center gap-2 bg-[#b89758] hover:bg-[#a6864a] text-black text-xs font-sans font-bold uppercase tracking-wider py-2.5 px-5 rounded-[2px] transition-colors"
                    >
                        <span>SHOP SHIRTS</span>
                        <span>&rarr;</span>
                    </a>
                </div>
            </div>
            <!-- Flatlay Product Image on Right -->
            <div class="absolute right-0 top-0 bottom-0 w-1/2 flex items-center justify-end overflow-hidden">
                <img 
                    src="{{ asset('placeholders/product_1_main.jpg') }}" 
                    alt="Shirts Collection" 
                    class="h-full w-full object-cover object-center group-hover:scale-105 transition-transform duration-500"
                    x-on:error="$event.target.src = '/placeholders/outfitter_prod_1.jpg'"
                >
            </div>
        </div>

        <!-- Banner 2 (Right - Dark Luxury Stylish Trousers) -->
        <div class="relative bg-[#141414] rounded overflow-hidden min-h-[220px] sm:min-h-[260px] flex items-center p-6 sm:p-10 group">
            <div class="relative z-10 max-w-[280px] space-y-2">
                <span class="text-[10px] font-sans font-bold tracking-widest uppercase text-gray-400 block">
                    PERFECT FIT FOR EVERY OCCASION
                </span>
                <h3 class="font-serif text-2xl sm:text-3xl font-normal uppercase text-white leading-tight">
                    STYLISH TROUSERS
                </h3>
                <div class="pt-3">
                    <a 
                        href="{{ route('storefront.shop', ['category' => 'TROUSERS']) }}" 
                        class="inline-flex items-center gap-2 bg-[#b89758] hover:bg-[#a6864a] text-black text-xs font-sans font-bold uppercase tracking-wider py-2.5 px-5 rounded-[2px] transition-colors"
                    >
                        <span>SHOP TROUSERS</span>
                        <span>&rarr;</span>
                    </a>
                </div>
            </div>
            <!-- Flatlay Product Image on Right -->
            <div class="absolute right-0 top-0 bottom-0 w-1/2 flex items-center justify-end overflow-hidden">
                <img 
                    src="{{ asset('placeholders/product_4_main.jpg') }}" 
                    alt="Trousers Collection" 
                    class="h-full w-full object-cover object-center group-hover:scale-105 transition-transform duration-500 brightness-95"
                    x-on:error="$event.target.src = '/placeholders/outfitter_prod_4.jpg'"
                >
            </div>
        </div>

    </div>
</section>

<!-- 5. BEST SELLERS (REFERENCE MATCH: 6-COLUMN PRODUCT GRID) -->
<section class="py-14 bg-white border-b border-gray-100">
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        
        <div class="flex items-center justify-between pb-2 border-b border-gray-100">
            <!-- Title with Horizontal Gold Line -->
            <div class="flex items-center gap-3">
                <h2 class="font-serif text-2xl sm:text-3xl font-normal uppercase tracking-wide text-neutral-900">
                    BEST SELLERS
                </h2>
                <div class="w-12 h-0.5 bg-[#b89758]"></div>
            </div>

            <a 
                href="{{ route('storefront.shop', ['tag' => 'Best Seller']) }}" 
                class="border border-gray-300 hover:border-black text-neutral-800 text-[11px] px-3.5 py-1.5 rounded-[2px] transition-colors"
            >
                View All &rarr;
            </a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3 sm:gap-4">
            @foreach($bestSellers->take(6) as $product)
                @include('storefront.partials.product-card', ['product' => $product])
            @endforeach
        </div>
    </div>
</section>

<!-- 6. 4 TRUST BADGES (REFERENCE MATCH) -->
<section class="py-12 bg-white border-b border-gray-100 select-none">
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-2 md:grid-cols-4 gap-6 text-center font-sans">
        
        <div class="flex flex-col items-center p-4">
            <span class="text-3xl mb-2">🚚</span>
            <h4 class="text-xs font-bold uppercase tracking-wider text-neutral-900">Free Delivery</h4>
            <p class="text-xs text-gray-400 mt-0.5">All Over Pakistan</p>
        </div>

        <div class="flex flex-col items-center p-4">
            <span class="text-3xl mb-2">💵</span>
            <h4 class="text-xs font-bold uppercase tracking-wider text-neutral-900">Cash On Delivery</h4>
            <p class="text-xs text-gray-400 mt-0.5">Pay When You Receive</p>
        </div>

        <div class="flex flex-col items-center p-4">
            <span class="text-3xl mb-2">📦</span>
            <h4 class="text-xs font-bold uppercase tracking-wider text-neutral-900">Easy Return</h4>
            <p class="text-xs text-gray-400 mt-0.5">Hassle Free Returns</p>
        </div>

        <div class="flex flex-col items-center p-4">
            <span class="text-3xl mb-2">🏅</span>
            <h4 class="text-xs font-bold uppercase tracking-wider text-neutral-900">Premium Quality</h4>
            <p class="text-xs text-gray-400 mt-0.5">Best Fabric & Stitching</p>
        </div>

    </div>
</section>

<!-- 7. FOLLOW US ON INSTAGRAM (REFERENCE MATCH: 8 LIFESTYLE IMAGES) -->
<section class="py-14 bg-white select-none">
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        
        <div class="flex items-center justify-between pb-2">
            <div class="flex items-center gap-3">
                <h2 class="font-serif text-2xl sm:text-3xl font-normal uppercase tracking-wide text-neutral-900">
                    FOLLOW US ON INSTAGRAM
                </h2>
                <div class="w-12 h-0.5 bg-[#b89758]"></div>
            </div>

            <div class="flex items-center gap-3 text-xs">
                <span class="text-gray-400">@trendhubstore</span>
                <a 
                    href="{{ $settings['web_instagram_link'] ?? 'https://instagram.com' }}" 
                    target="_blank" 
                    class="border border-gray-300 hover:border-black text-neutral-800 text-[11px] px-3.5 py-1.5 rounded-[2px] transition-colors"
                >
                    View Gallery &rarr;
                </a>
            </div>
        </div>

        <!-- 8 Grid Images -->
        <div class="grid grid-cols-4 sm:grid-cols-8 gap-2 sm:gap-3">
            @php
                $instaPlaceholders = [
                    'placeholders/product_1_main.jpg',
                    'placeholders/outfitter_prod_5.jpg',
                    'placeholders/outfitter_prod_1.jpg',
                    'placeholders/product_3_main.jpg',
                    'placeholders/outfitter_prod_7.jpg',
                    'placeholders/product_4_main.jpg',
                    'placeholders/outfitter_prod_2.jpg',
                    'placeholders/outfitter_prod_6.jpg',
                ];
            @endphp
            @foreach($instaPlaceholders as $idx => $img)
                <div class="aspect-square overflow-hidden bg-gray-100 group relative">
                    <img 
                        src="{{ asset($img) }}" 
                        alt="Instagram Fashion Drop" 
                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                        x-on:error="$event.target.src = '/placeholders/outfitter_prod_1.jpg'"
                    >
                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-white">
                        <i data-lucide="instagram" class="w-5 h-5"></i>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</section>

<!-- 8. NEWSLETTER SUBSCRIBE BAR (REFERENCE MATCH) -->
<section class="bg-[#111111] py-8 text-white select-none border-t border-neutral-800">
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="flex items-center gap-4 text-center md:text-left">
            <div class="text-3xl text-[#c5a880]">
                ✉️
            </div>
            <div>
                <h4 class="font-sans font-bold text-sm sm:text-base uppercase tracking-wider text-white">
                    SUBSCRIBE TO OUR NEWSLETTER
                </h4>
                <p class="text-xs text-gray-400 font-sans">
                    Get the latest updates, new arrivals and exclusive offers.
                </p>
            </div>
        </div>

        <form onsubmit="event.preventDefault(); alert('Thank you for subscribing!'); this.reset();" class="flex w-full md:w-auto max-w-md">
            <input 
                type="email" 
                placeholder="Enter your email address..." 
                class="bg-white text-black text-xs px-4 py-2.5 rounded-l-md w-full md:w-72 focus:outline-none"
                required
            >
            <button 
                type="submit" 
                class="bg-[#b89758] hover:bg-[#a6864a] text-black font-sans font-bold text-xs uppercase px-6 py-2.5 rounded-r-md transition-colors cursor-pointer shrink-0"
            >
                Subscribe
            </button>
        </form>
    </div>
</section>

@endsection
