@extends('storefront.layout')

@section('title', 'Collections & Catalog | ' . ($settings['web_site_name'] ?? 'TrendHub'))

@section('content')
<div class="bg-white min-h-screen">
    <!-- Header Banner -->
    <div class="bg-neutral-900 text-white py-12 px-4 sm:px-6 lg:px-8 text-center space-y-2">
        <span class="text-[10px] sm:text-[11px] font-sans font-bold tracking-[0.3em] uppercase text-gray-400">
            ALL COLLECTIONS
        </span>
        <h1 class="font-serif text-3xl sm:text-4xl md:text-5xl font-light uppercase tracking-wide">
            {{ request('category') ?: (request('tag') ?: 'Elevated Menswear') }}
        </h1>
        <p class="text-xs sm:text-sm text-gray-300 font-light max-w-md mx-auto">
            Discover tailored shirts, casual polos, chinos, and refined accessories crafted for modern gentlemen.
        </p>
    </div>

    <!-- Filters & Catalog Container -->
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-10">
        
        <!-- Controls Bar: Category Filter Pills & Sort Select -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-8 border-b border-gray-100">
            
            <!-- Category Filter Pills -->
            <div class="flex items-center gap-2 overflow-x-auto scrollbar-none py-1">
                <a 
                    href="{{ route('storefront.shop') }}" 
                    class="px-4 py-2 rounded-full text-xs font-sans font-bold tracking-wider uppercase transition-all shrink-0 {{ !request('category') && !request('tag') ? 'bg-black text-white shadow-xs' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}"
                >
                    All Items
                </a>
                @foreach($categories as $cat)
                    <a 
                        href="{{ route('storefront.shop', ['category' => $cat->name]) }}" 
                        class="px-4 py-2 rounded-full text-xs font-sans font-bold tracking-wider uppercase transition-all shrink-0 {{ request('category') == $cat->name ? 'bg-black text-white shadow-xs' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}"
                    >
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>

            <!-- Sort Form -->
            <div class="flex items-center gap-3 shrink-0 self-end md:self-auto text-xs font-sans">
                <span class="text-gray-400 font-medium">Sort By:</span>
                <form action="{{ route('storefront.shop') }}" method="GET" class="flex items-center">
                    @if(request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif
                    @if(request('tag')) <input type="hidden" name="tag" value="{{ request('tag') }}"> @endif
                    @if(request('q')) <input type="hidden" name="q" value="{{ request('q') }}"> @endif
                    
                    <select 
                        name="sort" 
                        onchange="this.form.submit()" 
                        class="border border-gray-200 rounded-lg px-3 py-1.5 text-xs font-semibold focus:outline-none focus:border-black cursor-pointer bg-white"
                    >
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest Releases</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                    </select>
                </form>
            </div>
        </div>

        <!-- Products Grid -->
        @if($paginator->count() > 0)
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6 pt-8">
                @foreach($paginator as $product)
                    @include('storefront.partials.product-card', ['product' => $product])
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="pt-12 flex justify-center">
                {{ $paginator->links() }}
            </div>
        @else
            <div class="text-center py-24 space-y-4">
                <i data-lucide="package-search" class="w-12 h-12 text-gray-300 mx-auto"></i>
                <h3 class="text-sm uppercase font-bold tracking-widest text-neutral-800">No Products Found</h3>
                <p class="text-xs text-gray-400">Try adjusting your filters or search terms.</p>
                <a href="{{ route('storefront.shop') }}" class="inline-block bg-black text-white text-xs uppercase font-bold tracking-widest px-6 py-2.5 rounded-full">
                    Clear Filters
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
