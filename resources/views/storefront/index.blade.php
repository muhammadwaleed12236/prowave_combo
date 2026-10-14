@extends('storefront.layout')

@section('title', ($settings['web_site_name'] ?? 'TrendHub') . ' | Modern Luxury Menswear')

@section('content')

<!-- 1. Hero Section -->
<section class="relative w-full h-[85vh] min-h-[580px] max-h-[850px] overflow-hidden flex items-center justify-center bg-neutral-950">
    <!-- Background Image / Video -->
    <div class="absolute inset-0 z-0">
        @php
            $heroImg = !empty($settings['web_home_hero_image']) ? asset($settings['web_home_hero_image']) : asset('placeholders/outfitter_prod_5.jpg');
        @endphp
        <img 
            src="{{ $heroImg }}" 
            alt="Hero Background" 
            class="w-full h-full object-cover object-center opacity-85 transform scale-105 transition-transform duration-1000"
            onerror="this.src='/placeholders/outfitter_prod_5.jpg'"
        >
        <!-- Dark Luxury Gradients -->
        <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/40 to-transparent z-10"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-neutral-950 via-transparent to-black/60 z-10"></div>
    </div>

    <!-- Main Hero Content -->
    <div class="relative z-20 max-w-[1400px] mx-auto w-full px-6 sm:px-12 my-auto py-10 flex flex-col items-start justify-center space-y-5">
        <div class="space-y-2 max-w-[680px]">
            <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-serif font-bold tracking-tight text-white leading-tight uppercase">
                {{ $settings['web_hero_title'] ?? (($settings['web_site_name'] ?? 'TrendHub') . ' Menswear') }}
            </h1>
            <p class="text-sm sm:text-base md:text-lg font-sans text-gray-200 tracking-wide font-light">
                {{ $settings['web_hero_subtitle'] ?? 'Elevated Men\'s Apparel — Shirts, Trousers, Polos & Tailored Staples' }}
            </p>
        </div>

        <div class="text-[10px] sm:text-xs font-sans uppercase tracking-[0.25em] text-gray-300 font-semibold border-l-2 border-white pl-3">
            {{ $settings['web_hero_tagline'] ?? 'FALL / WINTER 2026 COLLECTION • PREMIUM COTTON & LINEN FABRICS' }}
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-wrap gap-3.5 pt-2">
            <a 
                href="{{ !empty($settings['web_hero_btn1_link']) ? $settings['web_hero_btn1_link'] : route('storefront.shop') }}" 
                class="bg-white hover:bg-neutral-200 text-black px-7 sm:px-8 py-3 rounded-full text-[10px] sm:text-xs font-sans uppercase tracking-[0.2em] font-bold shadow-lg transition-all duration-300 hover:scale-105"
            >
                {{ $settings['web_hero_btn1_text'] ?? 'SHOP COLLECTION' }}
            </a>
            <a 
                href="{{ !empty($settings['web_hero_btn2_link']) ? $settings['web_hero_btn2_link'] : route('storefront.shop', ['tag' => 'Best Seller']) }}" 
                class="border border-white/50 hover:border-white text-white hover:bg-white/10 px-7 sm:px-8 py-3 rounded-full text-[10px] sm:text-xs font-sans uppercase tracking-[0.2em] font-bold transition-all duration-300"
            >
                {{ $settings['web_hero_btn2_text'] ?? 'EXPLORE MENSWEAR' }}
            </a>
        </div>
    </div>
</section>

<!-- 2. Categories Circular Navigation Strip -->
@if(count($categories) > 0)
<section class="py-12 bg-white border-b border-gray-100 select-none">
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center pb-6">
            <span class="text-[10px] sm:text-[11px] font-sans font-bold tracking-[0.25em] uppercase text-gray-400">
                BROWSE BY CATEGORY
            </span>
            <h2 class="font-serif text-2xl sm:text-3xl uppercase tracking-wide font-normal text-neutral-900 mt-1">
                Refined Wardrobe Essentials
            </h2>
        </div>

        <!-- Scrollable Category Carousel -->
        <div class="flex items-center gap-6 sm:gap-8 overflow-x-auto scrollbar-none py-2 justify-start sm:justify-center">
            @foreach($categories as $cat)
                @php
                    $catImg = !empty($cat->web_image) ? asset($cat->web_image) : asset('placeholders/outfitter_prod_1.jpg');
                @endphp
                <a 
                    href="{{ route('storefront.shop', ['category' => $cat->name]) }}" 
                    class="flex flex-col items-center gap-2 group shrink-0"
                >
                    <div class="w-18 h-18 sm:w-20 sm:h-20 rounded-full overflow-hidden border border-gray-200 group-hover:border-black transition-all duration-300 group-hover:scale-105 shadow-xs bg-gray-50">
                        <img 
                            src="{{ $catImg }}" 
                            alt="{{ $cat->name }}" 
                            class="w-full h-full object-cover"
                            onerror="this.src='/placeholders/outfitter_prod_1.jpg'"
                        >
                    </div>
                    <span class="text-[11px] font-sans font-bold uppercase tracking-wider text-neutral-800 group-hover:text-black transition-colors">
                        {{ $cat->name }}
                    </span>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- 3. New Arrivals Slider Section -->
@if(count($newArrivals) > 0)
<section class="py-16 bg-[#fafafa] border-b border-gray-100" x-data="{
    scrollSlider(direction) {
        const el = this.$refs.slider;
        const amount = direction === 'left' ? -320 : 320;
        el.scrollBy({ left: amount, behavior: 'smooth' });
    }
}">
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header with Arrows -->
        <div class="flex items-end justify-between mb-8 pb-4 border-b border-gray-200">
            <div>
                <span class="text-[10px] sm:text-[11px] font-sans font-bold tracking-[0.25em] uppercase text-gray-400">
                    JUST DROPPED
                </span>
                <h2 class="font-serif text-2xl sm:text-3xl md:text-4xl uppercase tracking-wide font-normal text-neutral-900 mt-1">
                    New Arrivals
                </h2>
            </div>
            <div class="flex items-center gap-2">
                <button 
                    @click="scrollSlider('left')" 
                    class="w-9 h-9 rounded-full border border-gray-200 bg-white text-black hover:bg-neutral-900 hover:text-white flex items-center justify-center transition-all shadow-xs cursor-pointer"
                    aria-label="Previous"
                >
                    <i data-lucide="chevron-left" class="w-4 h-4"></i>
                </button>
                <button 
                    @click="scrollSlider('right')" 
                    class="w-9 h-9 rounded-full border border-gray-200 bg-white text-black hover:bg-neutral-900 hover:text-white flex items-center justify-center transition-all shadow-xs cursor-pointer"
                    aria-label="Next"
                >
                    <i data-lucide="chevron-right" class="w-4 h-4"></i>
                </button>
            </div>
        </div>

        <!-- Horizontal Products Track -->
        <div 
            x-ref="slider" 
            class="flex gap-6 overflow-x-auto scrollbar-none scroll-smooth pb-4 select-none"
        >
            @foreach($newArrivals as $prod)
                <div class="w-[240px] sm:w-[270px] md:w-[290px] shrink-0">
                    @include('storefront.partials.product-card', ['product' => $prod])
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- 4. Featured Menswear Collections (Alpine Interactive Category Filter) -->
<section class="py-16 bg-white border-b border-gray-100" x-data="{
    activeTab: 'ALL',
    scrollCol(direction) {
        const el = this.$refs.colSlider;
        const amount = direction === 'left' ? -320 : 320;
        el.scrollBy({ left: amount, behavior: 'smooth' });
    }
}">
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Center Header -->
        <div class="text-center space-y-2 mb-6">
            <span class="text-[10px] sm:text-[11px] font-sans font-bold tracking-[0.25em] uppercase text-gray-400">
                EXCLUSIVELY CURATED FOR YOU
            </span>
            <h2 class="font-serif text-3xl sm:text-4xl md:text-5xl tracking-wide font-normal text-neutral-900 uppercase">
                Featured Menswear Collections
            </h2>
            <p class="text-xs sm:text-sm text-gray-500 max-w-[600px] mx-auto font-sans">
                Discover modern luxury wardrobe staples designed with clean minimal aesthetics and timeless craftsmanship.
            </p>

            <!-- Category Pills Navigation -->
            <div class="flex items-center justify-center gap-2 max-w-[1000px] mx-auto px-2 pt-4 flex-wrap">
                <button 
                    @click="activeTab = 'ALL'"
                    class="px-5 sm:px-6 py-2 rounded-full text-xs font-sans font-bold tracking-widest uppercase transition-all duration-300 cursor-pointer"
                    :class="activeTab === 'ALL' ? 'bg-neutral-950 text-white shadow-md scale-105' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'"
                >
                    ALL
                </button>
                @foreach($categories as $c)
                    <button 
                        @click="activeTab = '{{ strtoupper($c->name) }}'"
                        class="px-5 sm:px-6 py-2 rounded-full text-xs font-sans font-bold tracking-widest uppercase transition-all duration-300 cursor-pointer"
                        :class="activeTab === '{{ strtoupper($c->name) }}' ? 'bg-neutral-950 text-white shadow-md scale-105' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'"
                    >
                        {{ $c->name }}
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Navigation Bar with Counter & Arrow Controls -->
        <div class="flex items-center justify-between border-b border-gray-100 pb-3 px-2 pt-4">
            <span class="text-xs font-sans font-bold uppercase tracking-widest text-neutral-400">
                <span x-text="activeTab === 'ALL' ? 'All Items' : activeTab"></span>
            </span>
            <div class="flex items-center gap-2">
                <button 
                    @click="scrollCol('left')" 
                    class="w-9 h-9 rounded-full border border-gray-200 bg-white text-neutral-800 hover:bg-neutral-900 hover:text-white flex items-center justify-center transition-all shadow-xs cursor-pointer"
                    aria-label="Previous Products"
                >
                    <i data-lucide="chevron-left" class="w-4 h-4"></i>
                </button>
                <button 
                    @click="scrollCol('right')" 
                    class="w-9 h-9 rounded-full border border-gray-200 bg-white text-neutral-800 hover:bg-neutral-900 hover:text-white flex items-center justify-center transition-all shadow-xs cursor-pointer"
                    aria-label="Next Products"
                >
                    <i data-lucide="chevron-right" class="w-4 h-4"></i>
                </button>
            </div>
        </div>

        <!-- Products Carousel Filtered Client-Side with Alpine.js -->
        <div 
            x-ref="colSlider" 
            class="flex gap-6 overflow-x-auto scrollbar-none scroll-smooth pb-4 pt-4 select-none"
        >
            @foreach($allProducts as $prod)
                @php
                    $catName = strtoupper($prod->category_relation ? $prod->category_relation->name : '');
                    $itemName = strtoupper($prod->item_name);
                @endphp
                <div 
                    class="w-[240px] sm:w-[270px] md:w-[290px] shrink-0"
                    x-show="activeTab === 'ALL' || '{{ $catName }}' === activeTab || '{{ $catName }}'.includes(activeTab) || '{{ $itemName }}'.includes(activeTab)"
                    x-transition
                >
                    @include('storefront.partials.product-card', ['product' => $prod])
                </div>
            @endforeach
        </div>

        <!-- View All Link -->
        <div class="text-center pt-6">
            <a 
                href="{{ route('storefront.shop') }}" 
                class="inline-block bg-neutral-900 hover:bg-black text-white text-xs font-sans font-bold uppercase tracking-[0.25em] px-8 py-3.5 rounded-full shadow-md transition-all duration-300 hover:scale-105"
            >
                View All Products
            </a>
        </div>
    </div>
</section>

<!-- 5. Best Sellers Section -->
@if(count($bestSellers) > 0)
<section class="py-16 bg-[#fafafa] border-b border-gray-100">
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between mb-8 pb-4 border-b border-gray-200">
            <div>
                <span class="text-[10px] sm:text-[11px] font-sans font-bold tracking-[0.25em] uppercase text-gray-400">
                    SIGNATURE PIECES
                </span>
                <h2 class="font-serif text-2xl sm:text-3xl md:text-4xl uppercase tracking-wide font-normal text-neutral-900 mt-1">
                    Best Sellers
                </h2>
            </div>
            <a href="{{ route('storefront.shop', ['tag' => 'Best Seller']) }}" class="text-xs uppercase font-bold tracking-widest text-neutral-800 hover:text-black underline flex items-center gap-1">
                View All <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
            </a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6">
            @foreach($bestSellers->take(8) as $prod)
                @include('storefront.partials.product-card', ['product' => $prod])
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- 6. Full-Width Seasonal Banner -->
@if(!empty($settings['web_home_banner_image']))
<section class="relative w-full h-[350px] sm:h-[450px] overflow-hidden bg-black flex items-center justify-center">
    <img 
        src="{{ asset($settings['web_home_banner_image']) }}" 
        alt="Promotion Banner" 
        class="w-full h-full object-cover opacity-80"
        onerror="this.src='/placeholders/outfitter_prod_7.jpg'"
    >
    <div class="absolute inset-0 bg-black/40"></div>
    <div class="relative z-10 text-center text-white px-6 space-y-3 max-w-2xl">
        <span class="text-[10px] sm:text-xs font-bold uppercase tracking-[0.3em] text-gray-300">LIMITED TIME OFFER</span>
        <h3 class="font-serif text-3xl sm:text-4xl md:text-5xl font-light uppercase tracking-wide">
            {{ $settings['web_home_banner_text'] ?? 'Refined Luxury Tailoring' }}
        </h3>
        <p class="text-xs sm:text-sm text-gray-200 font-light">Crafted from long-staple cotton with clean cuts and precision stitching.</p>
        <div class="pt-2">
            <a href="{{ route('storefront.shop') }}" class="inline-block bg-white text-black font-bold text-xs uppercase tracking-widest px-8 py-3 rounded-full hover:bg-neutral-200 transition-all">
                Shop The Sale
            </a>
        </div>
    </div>
</section>
@endif

<!-- 7. Brand Pillars / Why TrendHub -->
<section class="py-16 bg-white select-none">
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 text-center font-sans">
        
        <div class="space-y-2 p-6 rounded-xl border border-gray-100 hover:border-gray-200 transition-colors">
            <div class="w-12 h-12 mx-auto rounded-full bg-neutral-100 flex items-center justify-center text-black">
                <i data-lucide="truck" class="w-5 h-5"></i>
            </div>
            <h4 class="text-xs font-bold uppercase tracking-wider text-black">Nationwide Express Delivery</h4>
            <p class="text-xs text-gray-500 leading-relaxed">Dispatched within 24 hours. Free delivery on orders over PKR 5,000.</p>
        </div>

        <div class="space-y-2 p-6 rounded-xl border border-gray-100 hover:border-gray-200 transition-colors">
            <div class="w-12 h-12 mx-auto rounded-full bg-neutral-100 flex items-center justify-center text-black">
                <i data-lucide="sparkles" class="w-5 h-5"></i>
            </div>
            <h4 class="text-xs font-bold uppercase tracking-wider text-black">Premium Tailored Fabrics</h4>
            <p class="text-xs text-gray-500 leading-relaxed">Sourced from top mills ensuring breathability, durability, and comfort.</p>
        </div>

        <div class="space-y-2 p-6 rounded-xl border border-gray-100 hover:border-gray-200 transition-colors">
            <div class="w-12 h-12 mx-auto rounded-full bg-neutral-100 flex items-center justify-center text-black">
                <i data-lucide="rotate-ccw" class="w-5 h-5"></i>
            </div>
            <h4 class="text-xs font-bold uppercase tracking-wider text-black">7-Day Easy Exchange</h4>
            <p class="text-xs text-gray-500 leading-relaxed">Size doesn't fit? Exchange your apparel effortlessly within 7 days.</p>
        </div>

        <div class="space-y-2 p-6 rounded-xl border border-gray-100 hover:border-gray-200 transition-colors">
            <div class="w-12 h-12 mx-auto rounded-full bg-neutral-100 flex items-center justify-center text-black">
                <i data-lucide="message-square" class="w-5 h-5"></i>
            </div>
            <h4 class="text-xs font-bold uppercase tracking-wider text-black">Dedicated Support</h4>
            <p class="text-xs text-gray-500 leading-relaxed">Personal styling and sizing advice available anytime on WhatsApp.</p>
        </div>
    </div>
</section>

@endsection
