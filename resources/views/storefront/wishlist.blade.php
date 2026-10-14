@extends('storefront.layout')

@section('title', 'My Wishlist | ' . ($settings['web_site_name'] ?? 'TrendHub'))

@section('content')
<div class="bg-white min-h-[70vh] py-12 px-4 sm:px-6 lg:px-8 font-sans">
    <div class="max-w-[1400px] mx-auto space-y-8">
        
        <div class="text-center space-y-1">
            <span class="text-[10px] font-sans font-bold tracking-[0.25em] uppercase text-gray-400">SAVED PIECES</span>
            <h1 class="font-serif text-3xl sm:text-4xl uppercase tracking-wide font-normal text-neutral-900">
                My Wishlist (<span x-text="wishlist.length"></span>)
            </h1>
        </div>

        <template x-if="wishlist.length === 0">
            <div class="text-center py-20 space-y-4 max-w-sm mx-auto">
                <i data-lucide="heart" class="w-12 h-12 text-gray-300 mx-auto"></i>
                <h3 class="text-sm uppercase font-bold tracking-widest text-neutral-800">Your wishlist is empty</h3>
                <p class="text-xs text-gray-400">Explore our seasonal collections and tap the heart icon on any design to save it here.</p>
                <a href="{{ route('storefront.shop') }}" class="inline-block bg-black text-white text-xs uppercase font-bold tracking-widest px-8 py-3 rounded-full hover:bg-neutral-800">
                    Discover Pieces
                </a>
            </div>
        </template>

        <template x-if="wishlist.length > 0">
            <div class="space-y-4">
                <div class="flex justify-between items-center pb-3 border-b border-gray-100 text-xs">
                    <span class="text-gray-500">Items you've marked as favorites</span>
                    <button 
                        @click="wishlist = []; localStorage.removeItem('th_wishlist')" 
                        class="text-gray-400 hover:text-red-600 underline uppercase tracking-wider text-[10px]"
                    >
                        Clear All
                    </button>
                </div>
                <div class="p-8 text-center bg-gray-50 rounded-2xl border border-gray-100 space-y-3">
                    <p class="text-xs text-gray-600">You have <strong x-text="wishlist.length"></strong> pieces saved.</p>
                    <a href="{{ route('storefront.shop') }}" class="inline-block bg-black text-white text-xs font-bold uppercase tracking-widest px-6 py-2.5 rounded-full">
                        Browse All Products in Catalog
                    </a>
                </div>
            </div>
        </template>
    </div>
</div>
@endsection
