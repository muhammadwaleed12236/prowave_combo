<!-- Quick View Modal -->
<div 
    x-show="quickView.isOpen" 
    x-cloak 
    class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-5"
    @keydown.escape.window="closeQuickView()"
>
    <!-- Backdrop -->
    <div 
        x-show="quickView.isOpen"
        x-transition:enter="ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-black/75 backdrop-blur-xs" 
        @click="closeQuickView()"
    ></div>

    <!-- Modal Box -->
    <div 
        x-show="quickView.isOpen"
        x-transition:enter="ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="bg-white w-full max-w-2xl lg:max-w-3xl rounded-2xl shadow-2xl relative grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6 p-4 sm:p-5 md:p-6 z-10 text-left max-h-[92vh] md:max-h-none overflow-y-auto md:overflow-visible scrollbar-none"
        @click.outside="closeQuickView()"
    >
        <!-- Close Button -->
        <button 
            @click="closeQuickView()" 
            class="absolute top-3 right-3 text-gray-400 hover:text-black transition-colors z-20 cursor-pointer p-1.5 rounded-full hover:bg-neutral-100"
            aria-label="Close Modal"
        >
            <i data-lucide="x" class="w-5 h-5"></i>
        </button>

        <!-- Left Column: Image & Thumbnails -->
        <div class="flex flex-col gap-2.5 items-center justify-center">
            <div class="relative w-full aspect-[3/4] max-w-[240px] md:max-w-[270px] mx-auto overflow-hidden bg-gray-50 border border-gray-100 rounded-xl group select-none shadow-inner">
                <img 
                    :src="quickView.activeImg" 
                    :alt="quickView.product ? quickView.product.item_name : 'Product'" 
                    class="w-full h-full object-cover transition-all duration-300"
                    x-on:error="$event.target.src = '/placeholders/outfitter_prod_1.jpg'"
                >
            </div>

            <!-- Thumbnails strip -->
            <template x-if="quickView.product && quickView.product.gallery_images && quickView.product.gallery_images.length > 1">
                <div class="flex gap-2 overflow-x-auto py-0.5 scrollbar-none max-w-[270px]">
                    <template x-for="(imgUrl, gIdx) in quickView.product.gallery_images" :key="gIdx">
                        <button 
                            @click="quickView.activeImg = imgUrl" 
                            class="w-9 h-12 border rounded-md overflow-hidden shrink-0 transition-all cursor-pointer"
                            :class="quickView.activeImg === imgUrl ? 'border-black ring-1 ring-black scale-95' : 'border-gray-200 opacity-60 hover:opacity-100'"
                        >
                            <img :src="imgUrl" alt="Thumbnail" class="w-full h-full object-cover" x-on:error="$event.target.src = '/placeholders/outfitter_prod_1.jpg'">
                        </button>
                    </template>
                </div>
            </template>
        </div>

        <!-- Right Column: Info & Actions -->
        <div class="flex flex-col justify-between font-sans h-full space-y-2.5" x-show="quickView.product">
            <div class="space-y-2.5">
                <!-- Category & Title -->
                <div>
                    <span 
                        class="text-[10px] uppercase tracking-[0.2em] text-gray-400 font-bold block mb-0.5" 
                        x-text="(quickView.product.category_relation && quickView.product.category_relation.name) || 'Apparel'"
                    ></span>
                    <h2 class="font-serif text-lg sm:text-xl uppercase tracking-wide font-light text-black leading-tight" x-text="quickView.product.item_name"></h2>
                    <p class="text-[9px] text-gray-400 font-mono tracking-wider pt-0.5" x-show="quickView.product.item_code">
                        SKU: <span x-text="quickView.product.item_code"></span>
                    </p>
                </div>

                <!-- Price -->
                <div class="border-t border-b border-gray-100 py-2 flex items-baseline gap-2.5">
                    <span class="text-lg font-bold text-black font-sans">
                        PKR <span x-text="Math.round(quickView.product.final_price).toLocaleString()"></span>
                    </span>
                    <template x-if="quickView.product.discount_percent > 0">
                        <span class="text-xs text-gray-400 line-through font-light">
                            PKR <span x-text="Math.round(quickView.product.sale_price_per_piece || 0).toLocaleString()"></span>
                        </span>
                    </template>
                    <template x-if="quickView.product.discount_percent > 0">
                        <span class="text-[9px] font-bold text-white bg-[#7a0f12] px-2 py-0.5 rounded uppercase tracking-wider">
                            <span x-text="quickView.product.discount_percent"></span>% OFF
                        </span>
                    </template>
                </div>

                <!-- Description -->
                <p class="text-xs text-neutral-500 leading-relaxed font-light line-clamp-2">
                    Designed as part of our premium modern luxury apparel collection, this piece stands out with premium stitching and refined cuts.
                </p>

                <!-- Sizes Selector -->
                <template x-if="quickView.product.parsed_sizes && quickView.product.parsed_sizes.length > 0">
                    <div class="space-y-1">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-black block">
                            Size: <span class="text-gray-500 font-semibold" x-text="quickView.selectedSize"></span>
                        </span>
                        <div class="flex gap-1.5 flex-wrap">
                            <template x-for="sz in quickView.product.parsed_sizes" :key="sz">
                                <button 
                                    @click="quickView.selectedSize = sz"
                                    class="px-3 py-1 text-xs font-semibold tracking-wider transition-all duration-200 uppercase rounded-full border cursor-pointer"
                                    :class="quickView.selectedSize === sz ? 'border-black bg-black text-white shadow-sm' : 'border-gray-200 text-gray-600 hover:border-black bg-white'"
                                    x-text="sz"
                                ></button>
                            </template>
                        </div>
                    </div>
                </template>

                <!-- Colors Selector -->
                <template x-if="quickView.product.parsed_colors && quickView.product.parsed_colors.length > 0">
                    <div class="space-y-1">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-black block">
                            Color: <span class="text-gray-500 font-semibold capitalize" x-text="quickView.selectedColor"></span>
                        </span>
                        <div class="flex gap-1.5 flex-wrap max-h-24 overflow-y-auto scrollbar-none">
                            <template x-for="col in quickView.product.parsed_colors" :key="col">
                                <button 
                                    @click="quickView.selectedColor = col"
                                    class="px-3 py-1 text-xs font-semibold tracking-wider transition-all duration-200 uppercase rounded-full border cursor-pointer"
                                    :class="quickView.selectedColor === col ? 'border-black bg-black text-white shadow-sm' : 'border-gray-200 text-gray-600 hover:border-black bg-white'"
                                    x-text="col"
                                ></button>
                            </template>
                        </div>
                    </div>
                </template>

                <!-- Quantity -->
                <div class="flex items-center gap-3 pt-0.5">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-black">Quantity:</span>
                    <div class="flex items-center border border-gray-200 rounded-full py-0.5 px-1 w-max">
                        <button 
                            @click="quickView.qty = Math.max(1, quickView.qty - 1)" 
                            class="px-2 py-0.5 text-gray-400 hover:text-black font-bold"
                        >-</button>
                        <span class="px-2 text-xs text-black font-bold font-mono min-w-[20px] text-center" x-text="quickView.qty"></span>
                        <button 
                            @click="quickView.qty++" 
                            class="px-2 py-0.5 text-gray-400 hover:text-black font-bold"
                        >+</button>
                    </div>
                </div>
            </div>

            <!-- Action Buttons (Add to Cart & Buy Now side-by-side) -->
            <div class="pt-2 space-y-2">
                <div class="grid grid-cols-2 gap-2">
                    <button 
                        @click="addToCart(quickView.product, quickView.qty, quickView.selectedSize, quickView.selectedColor); closeQuickView()"
                        class="w-full bg-white hover:bg-neutral-900 hover:text-white text-neutral-900 text-xs font-sans font-bold tracking-wider uppercase transition-colors duration-300 py-2.5 border border-black rounded-lg cursor-pointer"
                    >
                        Add to Cart
                    </button>
                    <button 
                        @click="addToCart(quickView.product, quickView.qty, quickView.selectedSize, quickView.selectedColor); window.location.href = '{{ route('storefront.checkout') }}'"
                        class="w-full bg-black hover:bg-neutral-800 text-white text-xs font-sans font-bold tracking-wider uppercase transition-colors duration-300 py-2.5 rounded-lg cursor-pointer"
                    >
                        Buy It Now
                    </button>
                </div>
                <a 
                    :href="'/product/' + (quickView.product ? quickView.product.id : '')"
                    class="w-full text-center text-[10px] tracking-widest font-bold uppercase underline flex items-center justify-center gap-1.5 hover:text-neutral-600 transition-colors pt-0.5"
                >
                    View Full Details <i data-lucide="arrow-right" class="w-3 h-3"></i>
                </a>
            </div>
        </div>
    </div>
</div>
