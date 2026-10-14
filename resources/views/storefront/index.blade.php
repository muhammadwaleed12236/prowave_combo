@extends('storefront.layout')

@section('title', ($settings['web_site_name'] ?? 'TrendHub') . ' | Modern Luxury Menswear')

@section('content')

<!-- 1. HERO SECTION (DARK LUXURY OVERLAY + 4 BOTTOM DOCK CARDS) -->
<section class="relative w-full min-h-[92vh] flex flex-col justify-between overflow-hidden bg-neutral-950">
    <!-- Background Video / Image Layer with Premium Luxury Overlays -->
    <div class="absolute inset-0 z-0 overflow-hidden">
        @if(!empty($settings['web_home_hero_video']))
            <video
                autoplay
                muted
                loop
                playsinline
                preload="metadata"
                class="w-full h-full object-cover filter brightness-[0.55] contrast-[1.1]"
            >
                <source src="{{ asset($settings['web_home_hero_video']) }}" type="video/mp4">
            </video>
        @else
            @php
                $heroImg = !empty($settings['web_home_hero_image']) ? asset($settings['web_home_hero_image']) : asset('placeholders/outfitter_prod_5.jpg');
            @endphp
            <img 
                src="{{ $heroImg }}" 
                alt="Hero Fashion" 
                class="w-full h-full object-cover filter brightness-[0.6] contrast-[1.08] animate-hero-zoom"
                x-on:error="$event.target.src = '/placeholders/outfitter_prod_5.jpg'"
            >
        @endif
        <!-- Dark Vignette & Gradient Overlays -->
        <div class="absolute inset-0 bg-gradient-to-r from-black/85 via-black/45 to-transparent z-10 pointer-events-none"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-neutral-950 via-transparent to-black/65 z-10 pointer-events-none"></div>
    </div>

    <!-- Main Hero Content -->
    <div class="relative z-20 max-w-[1400px] mx-auto w-full px-6 sm:px-12 my-auto py-14 flex flex-col items-start justify-center space-y-6">
        <div class="space-y-3 max-w-[700px]">
            <h1 
                data-aos="fade-up" 
                data-aos-duration="800"
                class="text-2xl sm:text-3xl md:text-5xl lg:text-6xl font-sans font-bold tracking-tight text-white leading-tight uppercase"
            >
                {{ $settings['web_hero_title'] ?? (($settings['web_site_name'] ?? 'TrendHub') . ' Menswear') }}
            </h1>
            <p 
                data-aos="fade-up" 
                data-aos-delay="150" 
                data-aos-duration="800"
                class="text-sm sm:text-base md:text-lg font-sans text-gray-200 tracking-wide font-light"
            >
                {{ $settings['web_hero_subtitle'] ?? "Elevated Men's Apparel — Shirts, Trousers, Polos & Tailored Shorts" }}
            </p>
        </div>

        <div 
            data-aos="fade-right" 
            data-aos-delay="250" 
            data-aos-duration="700"
            class="text-[10px] sm:text-xs font-sans uppercase tracking-[0.22em] text-gray-300 font-semibold border-l-2 border-indigo-500 pl-3 py-0.5"
        >
            {{ $settings['web_hero_tagline'] ?? 'FALL / WINTER 2026 COLLECTION • PREMIUM COTTON & LINEN FABRICS' }}
        </div>

        <!-- Action Buttons -->
        <div 
            data-aos="fade-up" 
            data-aos-delay="350" 
            data-aos-duration="800"
            class="flex flex-wrap gap-3.5 pt-2"
        >
            <a 
                href="{{ !empty($settings['web_hero_btn1_link']) ? $settings['web_hero_btn1_link'] : route('storefront.shop') }}" 
                class="shimmer-btn animate-pulse-glow bg-[#4F46E5] hover:bg-[#4338CA] text-white px-7 sm:px-8 py-3 rounded-full text-[10px] sm:text-xs font-sans uppercase tracking-[0.2em] font-bold transition-all duration-300 hover:scale-105 active:scale-95"
            >
                {{ $settings['web_hero_btn1_text'] ?? 'SHOP COLLECTION' }}
            </a>
            <a 
                href="{{ !empty($settings['web_hero_btn2_link']) ? $settings['web_hero_btn2_link'] : route('storefront.shop', ['tag' => 'Featured']) }}" 
                class="border border-white/50 hover:border-white text-white hover:bg-white/15 px-7 sm:px-8 py-3 rounded-full text-[10px] sm:text-xs font-sans uppercase tracking-[0.2em] font-bold transition-all duration-300 hover:scale-105 active:scale-95"
            >
                {{ $settings['web_hero_btn2_text'] ?? 'EXPLORE MENSWEAR' }}
            </a>
        </div>
    </div>

    <!-- Hero Bottom Dock / 4 Featured Cards (Frosted Glassmorphic Overlay) -->
    <div class="relative z-20 w-full border-t border-white/20 bg-black/60 backdrop-blur-md">
        <div class="max-w-[1400px] mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 divide-y sm:divide-y-0 sm:divide-x divide-white/15">
            
            <!-- Card 1 -->
            <a 
                data-aos="fade-up" 
                data-aos-delay="100"
                href="{{ !empty($settings['web_card1_link']) ? $settings['web_card1_link'] : (isset($allProducts[0]) ? route('storefront.product', $allProducts[0]->id) : route('storefront.shop')) }}"
                class="p-6 flex flex-col justify-between space-y-3 relative group hover:bg-white/10 hover:-translate-y-1 transition-all duration-300 block cursor-pointer"
            >
                <div class="w-14 h-0.5 bg-white mb-1 transition-all duration-300 group-hover:w-20 group-hover:bg-indigo-400"></div>
                <div>
                    <span class="bg-[#4F46E5] text-white text-[9px] font-sans font-bold px-2.5 py-0.5 rounded uppercase tracking-wider inline-block mb-2 shadow-sm">
                        {{ $settings['web_card1_badge'] ?? 'FORMAL SHIRTS' }}
                    </span>
                    <h4 class="text-sm font-sans font-bold text-white tracking-wide group-hover:text-indigo-400 transition-colors">
                        {{ $settings['web_card1_title'] ?? ($allProducts[0]->item_name ?? 'Formal & Oxford Shirts') }}
                    </h4>
                    <p class="text-xs text-gray-400 font-sans line-clamp-1 mt-0.5">
                        {{ $settings['web_card1_subtext'] ?? '100% Egyptian Cotton • Slim & Tailored Fits' }}
                    </p>
                </div>
                <div class="text-[10px] text-gray-400 font-sans tracking-wider uppercase pt-2 border-t border-white/10 flex justify-between items-center">
                    <span>{{ $settings['web_card1_detail'] ?? 'PREMIUM COTTON' }}</span>
                    <span class="text-indigo-300 font-bold group-hover:translate-x-1 transition-transform">
                        {{ isset($allProducts[0]) ? 'RS. ' . number_format($allProducts[0]->final_price) : 'SHOP NOW' }} &rarr;
                    </span>
                </div>
            </a>

            <!-- Card 2 -->
            <a 
                data-aos="fade-up" 
                data-aos-delay="200"
                href="{{ !empty($settings['web_card2_link']) ? $settings['web_card2_link'] : (isset($allProducts[1]) ? route('storefront.product', $allProducts[1]->id) : route('storefront.shop')) }}"
                class="p-6 flex flex-col justify-between space-y-3 relative group hover:bg-white/10 hover:-translate-y-1 transition-all duration-300 block cursor-pointer"
            >
                <div>
                    <span class="bg-red-600 text-white text-[9px] font-sans font-bold px-2.5 py-0.5 rounded uppercase tracking-wider inline-flex items-center gap-1.5 mb-2 shadow-sm">
                        <span class="w-1.5 h-1.5 rounded-full bg-white animate-ping"></span>
                        {{ $settings['web_card2_badge'] ?? 'FLASH SALE' }}
                    </span>
                    <h4 class="text-sm font-sans font-bold text-white tracking-wide group-hover:text-indigo-400 transition-colors">
                        {{ $settings['web_card2_title'] ?? ($allProducts[1]->item_name ?? 'Chino Trousers & Pants') }}
                    </h4>
                    <p class="text-xs text-gray-400 font-sans line-clamp-1 mt-0.5">
                        {{ $settings['web_card2_subtext'] ?? 'Flexible Stretch Cotton • Modern Slim Cut' }}
                    </p>
                </div>
                <div class="text-[10px] text-red-400 font-sans tracking-wider font-bold uppercase pt-2 border-t border-white/10 flex justify-between items-center">
                    <span>{{ $settings['web_card2_detail'] ?? 'UP TO 30% OFF' }}</span>
                    <span class="text-white font-bold group-hover:translate-x-1 transition-transform">
                        {{ isset($allProducts[1]) ? 'RS. ' . number_format($allProducts[1]->final_price) : 'EXPLORE' }} &rarr;
                    </span>
                </div>
            </a>

            <!-- Card 3 -->
            <a 
                data-aos="fade-up" 
                data-aos-delay="300"
                href="{{ !empty($settings['web_card3_link']) ? $settings['web_card3_link'] : (isset($allProducts[2]) ? route('storefront.product', $allProducts[2]->id) : route('storefront.shop')) }}"
                class="p-6 flex flex-col justify-between space-y-3 relative group hover:bg-white/10 hover:-translate-y-1 transition-all duration-300 block cursor-pointer"
            >
                <div>
                    <span class="bg-[#9333EA] text-white text-[9px] font-sans font-bold px-2.5 py-0.5 rounded uppercase tracking-wider inline-block mb-2 shadow-sm">
                        {{ $settings['web_card3_badge'] ?? 'POLO SHIRTS' }}
                    </span>
                    <h4 class="text-sm font-sans font-bold text-white tracking-wide group-hover:text-indigo-400 transition-colors">
                        {{ $settings['web_card3_title'] ?? ($allProducts[2]->item_name ?? 'Essential Polos & Tees') }}
                    </h4>
                    <p class="text-xs text-gray-400 font-sans line-clamp-1 mt-0.5">
                        {{ $settings['web_card3_subtext'] ?? 'Breathable Pima Fabric • Timeless Style' }}
                    </p>
                </div>
                <div class="text-[10px] text-gray-400 font-sans tracking-wider uppercase pt-2 border-t border-white/10 flex justify-between items-center">
                    <span>{{ $settings['web_card3_detail'] ?? 'BEST SELLER' }}</span>
                    <span class="text-indigo-300 font-bold group-hover:translate-x-1 transition-transform">
                        {{ isset($allProducts[2]) ? 'RS. ' . number_format($allProducts[2]->final_price) : 'EXPLORE' }} &rarr;
                    </span>
                </div>
            </a>

            <!-- Card 4 -->
            <a 
                data-aos="fade-up" 
                data-aos-delay="400"
                href="{{ !empty($settings['web_card4_link']) ? $settings['web_card4_link'] : (isset($allProducts[3]) ? route('storefront.product', $allProducts[3]->id) : route('storefront.shop')) }}"
                class="p-6 flex flex-col justify-between space-y-3 relative group hover:bg-white/10 hover:-translate-y-1 transition-all duration-300 block cursor-pointer"
            >
                <div>
                    <span class="bg-emerald-600 text-white text-[9px] font-sans font-bold px-2.5 py-0.5 rounded uppercase tracking-wider inline-block mb-2 shadow-sm">
                        {{ $settings['web_card4_badge'] ?? 'CASUAL SHORTS' }}
                    </span>
                    <h4 class="text-sm font-sans font-bold text-white tracking-wide group-hover:text-indigo-400 transition-colors">
                        {{ $settings['web_card4_title'] ?? ($allProducts[3]->item_name ?? 'Tailored Casual Shorts') }}
                    </h4>
                    <p class="text-xs text-gray-400 font-sans line-clamp-1 mt-0.5">
                        {{ $settings['web_card4_subtext'] ?? 'Relaxed Tailoring • Everyday Comfort' }}
                    </p>
                </div>
                <div class="text-[10px] text-gray-400 font-sans tracking-wider uppercase pt-2 border-t border-white/10 flex justify-between items-center">
                    <span>{{ $settings['web_card4_detail'] ?? 'NEW RELEASE' }}</span>
                    <span class="text-indigo-300 font-bold group-hover:translate-x-1 transition-transform">
                        {{ isset($allProducts[3]) ? 'RS. ' . number_format($allProducts[3]->final_price) : 'BUY NOW' }} &rarr;
                    </span>
                </div>
            </a>

        </div>
    </div>
</section>

<!-- Scrollable Content Wrapper -->
<div class="relative z-10 bg-white w-full shadow-[0_-15px_30px_rgba(0,0,0,0.08)]">

    <!-- 1. CONTINUOUS HORIZONTAL FASHION STRIP (TICKER WITH HOVER PAUSE) -->
    <div class="relative z-10 w-full bg-neutral-900 border-t border-b border-neutral-800 py-3.5 select-none overflow-hidden">
        <div class="w-full relative flex items-center">
            <div class="animate-infinite-scroll flex gap-3 px-2">
                @php
                    $stripProducts = $allProducts->count() > 0 ? $allProducts->concat($allProducts)->take(24) : collect();
                @endphp
                @foreach($stripProducts as $p)
                    <a 
                        href="{{ route('storefront.product', $p->id) }}" 
                        class="w-[160px] sm:w-[200px] md:w-[240px] aspect-[4/5] shrink-0 relative bg-neutral-800 rounded-md overflow-hidden group border border-white/10 hover:border-indigo-500/50 hover:shadow-lg transition-all duration-300"
                    >
                        <img 
                            src="{{ asset($p->display_image) }}" 
                            alt="{{ $p->item_name }}" 
                            class="w-full h-full object-cover object-center group-hover:scale-110 transition-transform duration-700 ease-out brightness-90 group-hover:brightness-100"
                            x-on:error="$event.target.src = '/placeholders/outfitter_prod_1.jpg'"
                        >
                        <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-transparent to-transparent opacity-95 p-3 flex flex-col justify-end">
                            <span class="text-[10px] font-sans font-bold text-white uppercase tracking-wider line-clamp-1 group-hover:text-indigo-300 transition-colors">
                                {{ $p->item_name }}
                            </span>
                            <span class="text-[9px] font-sans font-semibold text-indigo-400">
                                RS. {{ number_format($p->final_price) }}
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- 1.5 FEATURED COLLECTIONS SECTION (ALPINE INTERACTIVE CATEGORY TABS & SLIDER) -->
    <section class="py-20 bg-white overflow-hidden border-b border-gray-100" x-data="{
        activeTab: 'ALL',
        scrollCollection(direction) {
            const el = this.$refs.colSlider;
            const amount = direction === 'left' ? -320 : 320;
            el.scrollBy({ left: amount, behavior: 'smooth' });
        }
    }">
        <div class="max-w-[1400px] mx-auto px-4 sm:px-6 space-y-10">
            
            <div class="space-y-3 text-center">
                <span 
                    data-aos="fade-right" 
                    class="text-[10px] sm:text-xs font-sans font-bold uppercase tracking-[0.3em] text-indigo-600 block"
                >
                    Exclusively Curated For You
                </span>
                <h2 
                    data-aos="fade-left" 
                    class="font-serif text-3xl sm:text-4xl md:text-5xl tracking-wide font-normal text-neutral-900 uppercase"
                >
                    Featured Menswear Collections
                </h2>
                <p 
                    data-aos="fade-up" 
                    class="text-xs sm:text-sm text-gray-500 max-w-[600px] mx-auto font-sans"
                >
                    Discover modern luxury wardrobe staples designed with clean minimal aesthetics and timeless craftsmanship.
                </p>

                <!-- Centered Category Filter Pills -->
                <div 
                    data-aos="zoom-in" 
                    data-aos-delay="200"
                    class="flex items-center justify-center gap-2 max-w-[1000px] mx-auto px-2 pt-4 flex-wrap"
                >
                    <button 
                        @click="activeTab = 'ALL'"
                        class="px-5 sm:px-6 py-2 rounded-full text-xs font-sans font-bold tracking-widest uppercase transition-all duration-300 cursor-pointer flex items-center gap-2 hover:scale-105 active:scale-95"
                        :class="activeTab === 'ALL' ? 'bg-neutral-950 text-white shadow-md scale-105' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'"
                    >
                        <span>ALL</span>
                    </button>
                    @foreach($categories as $cat)
                        <button 
                            @click="activeTab = '{{ strtoupper($cat->name) }}'"
                            class="px-5 sm:px-6 py-2 rounded-full text-xs font-sans font-bold tracking-widest uppercase transition-all duration-300 cursor-pointer flex items-center gap-2 hover:scale-105 active:scale-95"
                            :class="activeTab === '{{ strtoupper($cat->name) }}' ? 'bg-neutral-950 text-white shadow-md scale-105' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'"
                        >
                            @if(!empty($cat->web_image))
                                <img 
                                    src="{{ asset($cat->web_image) }}" 
                                    alt="{{ $cat->name }}" 
                                    class="w-4 h-4 rounded-full object-cover shrink-0 border border-white/40"
                                    x-on:error="$event.target.style.display = 'none'"
                                >
                            @endif
                            <span>{{ $cat->name }}</span>
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Slider Navigation Bar with < and > Controls -->
            <div 
                data-aos="fade-up"
                class="flex items-center justify-between border-b border-gray-100 pb-3 px-2 pt-2"
            >
                <span class="text-xs font-sans font-bold uppercase tracking-widest text-neutral-400">
                    <span x-text="activeTab === 'ALL' ? 'All Items' : activeTab"></span>
                </span>
                <div class="flex items-center gap-2">
                    <button 
                        @click="scrollCollection('left')" 
                        class="w-9 h-9 rounded-full border border-gray-200 bg-white text-neutral-800 hover:bg-neutral-900 hover:text-white flex items-center justify-center transition-all shadow-xs cursor-pointer hover:scale-110 active:scale-95"
                        aria-label="Previous Products"
                    >
                        <i data-lucide="chevron-left" class="w-4 h-4"></i>
                    </button>
                    <button 
                        @click="scrollCollection('right')" 
                        class="w-9 h-9 rounded-full border border-gray-200 bg-white text-neutral-800 hover:bg-neutral-900 hover:text-white flex items-center justify-center transition-all shadow-xs cursor-pointer hover:scale-110 active:scale-95"
                        aria-label="Next Products"
                    >
                        <i data-lucide="chevron-right" class="w-4 h-4"></i>
                    </button>
                </div>
            </div>

            <!-- Products Horizontal Carousel Slider -->
            <div 
                data-aos="fade-up" 
                data-aos-delay="200"
                x-ref="colSlider" 
                class="flex gap-6 overflow-x-auto scrollbar-none scroll-smooth pb-4 select-none"
            >
                @foreach($allProducts as $product)
                    @php
                        $catName = strtoupper($product->category_relation ? $product->category_relation->name : '');
                        $itemName = strtoupper($product->item_name);
                    @endphp
                    <div 
                        class="w-[240px] sm:w-[270px] md:w-[290px] shrink-0 transform transition-all duration-500 hover:-translate-y-1.5"
                        x-show="activeTab === 'ALL' || '{{ $catName }}' === activeTab || '{{ $catName }}'.includes(activeTab) || '{{ $itemName }}'.includes(activeTab)"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                    >
                        @include('storefront.partials.product-card', ['product' => $product])
                    </div>
                @endforeach
            </div>

            <!-- Bottom Explore Link -->
            <div data-aos="fade-up" class="text-center pt-2">
                <a 
                    href="{{ route('storefront.shop') }}" 
                    class="bg-[#333333] hover:bg-neutral-900 text-white px-8 py-3.5 text-xs uppercase tracking-[0.2em] font-sans font-bold transition-all duration-300 inline-block rounded-xs hover:scale-105 shadow-sm"
                >
                    View all products
                </a>
            </div>
        </div>
    </section>

    <!-- 2. DYNAMIC NEW ARRIVALS SLIDER -->
    @if(count($newArrivals) > 0)
    <section class="w-full bg-[#fafafa] py-20 overflow-hidden border-t border-gray-100 select-none" x-data="{
        scrollArrivals(direction) {
            const el = this.$refs.arrSlider;
            const amount = direction === 'left' ? -320 : 320;
            el.scrollBy({ left: amount, behavior: 'smooth' });
        }
    }">
        <div class="max-w-[1400px] mx-auto px-4 sm:px-6 space-y-10">
            <!-- Header & Controls -->
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                <div class="space-y-1 text-center sm:text-left">
                    <span data-aos="fade-right" class="text-[10px] sm:text-xs font-sans font-bold uppercase tracking-[0.3em] text-indigo-600 block">
                        Fresh Modern Drops
                    </span>
                    <h2 data-aos="fade-left" class="font-serif text-3xl sm:text-4xl lg:text-5xl tracking-wide font-normal text-neutral-900 uppercase">
                        New Arrivals
                    </h2>
                </div>
                
                <!-- Slider Arrows -->
                <div data-aos="fade-left" class="flex items-center gap-2">
                    <button 
                        @click="scrollArrivals('left')" 
                        class="w-10 h-10 rounded-full border border-gray-200 bg-white text-black flex items-center justify-center hover:bg-black hover:text-white transition-all shadow-xs cursor-pointer hover:scale-110 active:scale-95"
                        aria-label="Previous Products"
                    >
                        <i data-lucide="chevron-left" class="w-5 h-5"></i>
                    </button>
                    <button 
                        @click="scrollArrivals('right')" 
                        class="w-10 h-10 rounded-full border border-gray-200 bg-white text-black flex items-center justify-center hover:bg-black hover:text-white transition-all shadow-xs cursor-pointer hover:scale-110 active:scale-95"
                        aria-label="Next Products"
                    >
                        <i data-lucide="chevron-right" class="w-5 h-5"></i>
                    </button>
                </div>
            </div>

            <!-- Slider Track with Clean ProductCards -->
            <div 
                data-aos="fade-up"
                data-aos-delay="150"
                x-ref="arrSlider" 
                class="flex gap-5 sm:gap-6 overflow-x-auto scrollbar-none scroll-smooth pb-4 select-none"
            >
                @foreach($newArrivals as $prod)
                    <div class="w-[230px] sm:w-[260px] md:w-[280px] shrink-0 transform transition-all duration-300 hover:-translate-y-1.5">
                        @include('storefront.partials.product-card', ['product' => $prod])
                    </div>
                @endforeach
            </div>

            <div data-aos="fade-up" class="text-center pt-2">
                <a 
                    href="{{ route('storefront.shop', ['tag' => 'New Arrival']) }}" 
                    class="bg-[#222222] hover:bg-black text-white px-8 py-3.5 text-xs uppercase tracking-[0.2em] font-sans font-bold transition-all duration-300 inline-block rounded-xs hover:scale-105 shadow-sm"
                >
                    Explore all new arrivals
                </a>
            </div>
        </div>
    </section>
    @endif

    <!-- 3. TRENDING NOW SECTION -->
    @php
        $trendingProducts = $allProducts->filter(function($p) {
            return in_array($p->promo_tag, ['Trending', 'Featured', 'Hot']);
        })->values();
        if ($trendingProducts->count() < 4) {
            $trendingProducts = $allProducts->slice(1, 5)->values();
        }
    @endphp
    @if(count($trendingProducts) > 0)
    <section class="bg-white py-20 overflow-hidden border-t border-gray-100">
        <div class="max-w-[1400px] mx-auto px-6 space-y-10">
            <div data-aos="fade-up" class="text-center space-y-3">
                <h2 class="font-serif text-3xl sm:text-4xl tracking-wide font-normal text-neutral-800 uppercase">
                    Trending Now
                </h2>
                <p class="text-[10px] text-gray-400 uppercase tracking-widest font-sans">
                    Most wanted luxury essentials
                </p>
            </div>

            <div data-aos="fade-up" data-aos-delay="150" class="grid grid-cols-2 md:grid-cols-5 gap-5">
                @foreach($trendingProducts->take(5) as $product)
                    <div class="transform transition-all duration-300 hover:-translate-y-1.5">
                        @include('storefront.partials.product-card', ['product' => $product])
                    </div>
                @endforeach
            </div>

            <div data-aos="fade-up" class="pt-6 text-center">
                <a 
                    href="{{ route('storefront.shop', ['tag' => 'Trending']) }}" 
                    class="bg-[#333333] hover:bg-neutral-900 text-white px-8 py-3 text-[10px] sm:text-xs uppercase tracking-[0.2em] font-sans font-bold transition-all duration-300 inline-block rounded-xs hover:scale-105 shadow-sm"
                >
                    View all trending
                </a>
            </div>
        </div>
    </section>
    @endif

    <!-- 4. DYNAMIC BEST SELLERS SECTION -->
    @if(count($bestSellers) > 0)
    <section class="bg-[#fafafa] py-20 border-t border-gray-100 select-none">
        <div class="max-w-[1400px] mx-auto px-4 sm:px-6 space-y-10">
            <div data-aos="fade-up" class="text-center space-y-3">
                <span class="text-[10px] sm:text-xs font-sans font-bold uppercase tracking-[0.3em] text-indigo-600 block">
                    Top Rated Customer Favorites
                </span>
                <h2 class="font-serif text-3xl sm:text-4xl lg:text-5xl tracking-wide font-normal text-neutral-900 uppercase">
                    Best Sellers
                </h2>
                <p class="text-xs sm:text-sm text-gray-500 max-w-[550px] mx-auto font-sans font-light">
                    Our most in-demand wardrobe staples crafted with unmatched precision and premium fabrics.
                </p>
            </div>

            <!-- Dynamic Product Grid -->
            <div data-aos="fade-up" data-aos-delay="150" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 sm:gap-6">
                @foreach($bestSellers->take(10) as $product)
                    <div class="transform transition-all duration-300 hover:-translate-y-1.5">
                        @include('storefront.partials.product-card', ['product' => $product])
                    </div>
                @endforeach
            </div>

            <div data-aos="fade-up" class="pt-6 text-center">
                <a 
                    href="{{ route('storefront.shop', ['tag' => 'Best Seller']) }}" 
                    class="bg-[#222222] hover:bg-black text-white px-9 py-3.5 text-[10px] sm:text-xs uppercase tracking-[0.2em] font-sans font-bold transition-all duration-300 inline-block rounded-xs hover:scale-105 shadow-md"
                >
                    View all best sellers
                </a>
            </div>
        </div>
    </section>
    @endif

    <!-- 5. FULL-WIDTH SEASONAL BANNER -->
    @if(!empty($settings['web_home_banner_image']))
    <section data-aos="zoom-in" data-aos-duration="900" class="relative w-full h-[350px] sm:h-[450px] overflow-hidden bg-black flex items-center justify-center">
        <img 
            src="{{ asset($settings['web_home_banner_image']) }}" 
            alt="Promotion Banner" 
            class="w-full h-full object-cover opacity-80 animate-hero-zoom"
            x-on:error="$event.target.src = '/placeholders/outfitter_prod_7.jpg'"
        >
        <div class="absolute inset-0 bg-black/40"></div>
        <div class="relative z-10 text-center text-white px-6 space-y-3 max-w-2xl">
            <span class="text-[10px] sm:text-xs font-bold uppercase tracking-[0.3em] text-gray-300">LIMITED TIME OFFER</span>
            <h3 class="font-serif text-3xl sm:text-4xl md:text-5xl font-light uppercase tracking-wide">
                {{ $settings['web_home_banner_text'] ?? 'Refined Luxury Tailoring' }}
            </h3>
            <p class="text-xs sm:text-sm text-gray-200 font-light">Crafted from long-staple cotton with clean cuts and precision stitching.</p>
            <div class="pt-2">
                <a href="{{ route('storefront.shop') }}" class="inline-block bg-white text-black font-bold text-xs uppercase tracking-widest px-8 py-3 rounded-full hover:bg-neutral-200 transition-all hover:scale-105 shadow-lg">
                    Shop The Sale
                </a>
            </div>
        </div>
    </section>
    @endif

    <!-- 6. BRAND PILLARS / WHY TRENDHUB -->
    <section class="py-16 bg-white select-none border-t border-gray-100">
        <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 text-center font-sans">
            
            <div data-aos="fade-up" data-aos-delay="100" class="space-y-2 p-6 rounded-xl border border-gray-100 hover:border-gray-200 hover:-translate-y-2 hover:shadow-lg transition-all duration-300 group">
                <div class="w-12 h-12 mx-auto rounded-full bg-neutral-100 group-hover:bg-neutral-900 group-hover:text-white flex items-center justify-center text-black transition-colors duration-300">
                    <i data-lucide="truck" class="w-5 h-5"></i>
                </div>
                <h4 class="text-xs font-bold uppercase tracking-wider text-black">Nationwide Express Delivery</h4>
                <p class="text-xs text-gray-500 leading-relaxed">Dispatched within 24 hours. Free delivery on orders over PKR 5,000.</p>
            </div>

            <div data-aos="fade-up" data-aos-delay="200" class="space-y-2 p-6 rounded-xl border border-gray-100 hover:border-gray-200 hover:-translate-y-2 hover:shadow-lg transition-all duration-300 group">
                <div class="w-12 h-12 mx-auto rounded-full bg-neutral-100 group-hover:bg-neutral-900 group-hover:text-white flex items-center justify-center text-black transition-colors duration-300">
                    <i data-lucide="sparkles" class="w-5 h-5"></i>
                </div>
                <h4 class="text-xs font-bold uppercase tracking-wider text-black">Premium Tailored Fabrics</h4>
                <p class="text-xs text-gray-500 leading-relaxed">Sourced from top mills ensuring breathability, durability, and comfort.</p>
            </div>

            <div data-aos="fade-up" data-aos-delay="300" class="space-y-2 p-6 rounded-xl border border-gray-100 hover:border-gray-200 hover:-translate-y-2 hover:shadow-lg transition-all duration-300 group">
                <div class="w-12 h-12 mx-auto rounded-full bg-neutral-100 group-hover:bg-neutral-900 group-hover:text-white flex items-center justify-center text-black transition-colors duration-300">
                    <i data-lucide="rotate-ccw" class="w-5 h-5"></i>
                </div>
                <h4 class="text-xs font-bold uppercase tracking-wider text-black">7-Day Easy Exchange</h4>
                <p class="text-xs text-gray-500 leading-relaxed">Size doesn't fit? Exchange your apparel effortlessly within 7 days.</p>
            </div>

            <div data-aos="fade-up" data-aos-delay="400" class="space-y-2 p-6 rounded-xl border border-gray-100 hover:border-gray-200 hover:-translate-y-2 hover:shadow-lg transition-all duration-300 group">
                <div class="w-12 h-12 mx-auto rounded-full bg-neutral-100 group-hover:bg-neutral-900 group-hover:text-white flex items-center justify-center text-black transition-colors duration-300">
                    <i data-lucide="message-square" class="w-5 h-5"></i>
                </div>
                <h4 class="text-xs font-bold uppercase tracking-wider text-black">Dedicated Support</h4>
                <p class="text-xs text-gray-500 leading-relaxed">Personal styling and sizing advice available anytime on WhatsApp.</p>
            </div>
        </div>
    </section>

</div>

@endsection
