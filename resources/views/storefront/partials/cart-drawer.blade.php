<!-- Cart Drawer Overlay -->
<div 
    x-show="isCartOpen" 
    x-cloak 
    class="fixed inset-0 z-50 overflow-hidden" 
    aria-labelledby="slide-over-title" 
    role="dialog" 
    aria-modal="true"
>
    <!-- Background backdrop -->
    <div 
        x-show="isCartOpen"
        x-transition:enter="ease-in-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in-out duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-black/60 backdrop-blur-xs transition-opacity" 
        @click="isCartOpen = false"
    ></div>

    <div class="fixed inset-y-0 right-0 max-w-full flex pl-10">
        <div 
            x-show="isCartOpen"
            x-transition:enter="transform transition ease-in-out duration-300"
            x-transition:enter-start="translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transform transition ease-in-out duration-300"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full"
            class="w-screen max-w-md bg-white shadow-2xl flex flex-col"
        >
            <!-- Drawer Header -->
            <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-sm font-bold uppercase tracking-[0.2em] text-neutral-900 font-sans">
                    Shopping Bag (<span x-text="cartCount"></span>)
                </h3>
                <button 
                    @click="isCartOpen = false" 
                    class="p-1 text-gray-400 hover:text-black transition-colors rounded-full hover:bg-gray-100"
                >
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <!-- Free Shipping Progress -->
            <div class="bg-neutral-50 px-6 py-2.5 border-b border-gray-100 text-xs font-sans">
                <template x-if="cartSubtotal >= 5000">
                    <span class="text-emerald-700 font-medium">🎉 You qualify for FREE Nationwide Delivery!</span>
                </template>
                <template x-if="cartSubtotal < 5000">
                    <span class="text-neutral-500">
                        Add <strong class="text-black">PKR <span x-text="(5000 - cartSubtotal).toLocaleString()"></span></strong> more for Free Shipping
                    </span>
                </template>
            </div>

            <!-- Items List -->
            <div class="flex-1 overflow-y-auto px-6 py-4 divide-y divide-gray-100 scrollbar-none">
                <template x-if="cart.length === 0">
                    <div class="h-full flex flex-col items-center justify-center text-center py-16 text-gray-400 space-y-3">
                        <i data-lucide="shopping-bag" class="w-12 h-12 stroke-[1.2]"></i>
                        <p class="text-xs uppercase tracking-widest font-semibold text-neutral-800">Your bag is empty</p>
                        <p class="text-[11px] text-gray-400">Discover elevated wardrobe essentials from our latest collection.</p>
                        <a 
                            href="{{ route('storefront.shop') }}" 
                            @click="isCartOpen = false"
                            class="mt-2 inline-block bg-black text-white text-[10px] font-bold uppercase tracking-widest px-6 py-2.5 rounded-full hover:bg-neutral-800"
                        >
                            Explore Collections
                        </a>
                    </div>
                </template>

                <template x-for="(item, idx) in cart" :key="idx">
                    <div class="py-4 flex gap-4">
                        <img 
                            :src="item.image" 
                            :alt="item.name" 
                            class="w-20 h-24 object-cover rounded-lg border border-gray-100 shrink-0 bg-gray-50"
                            x-on:error="$event.target.src = '/placeholders/outfitter_prod_1.jpg'"
                        >
                        <div class="flex-1 flex flex-col justify-between font-sans">
                            <div>
                                <h4 class="text-xs font-semibold text-neutral-900 uppercase tracking-wide leading-snug" x-text="item.name"></h4>
                                <div class="text-[10px] text-gray-500 pt-0.5 space-x-2">
                                    <span x-show="item.selectedSize" class="uppercase">Size: <strong class="text-black" x-text="item.selectedSize"></strong></span>
                                    <span x-show="item.selectedColor" class="capitalize">Color: <strong class="text-black" x-text="item.selectedColor"></strong></span>
                                </div>
                                <div class="text-xs font-bold text-neutral-900 pt-1">
                                    PKR <span x-text="(item.price * item.quantity).toLocaleString()"></span>
                                </div>
                            </div>

                            <div class="flex items-center justify-between pt-2">
                                <!-- Qty controls -->
                                <div class="flex items-center border border-gray-200 rounded-full py-0.5 px-1.5">
                                    <button 
                                        @click="updateCartQty(idx, item.quantity - 1)" 
                                        class="px-1.5 text-gray-400 hover:text-black text-xs font-bold"
                                    >-</button>
                                    <span class="px-2 text-xs font-mono font-bold" x-text="item.quantity"></span>
                                    <button 
                                        @click="updateCartQty(idx, item.quantity + 1)" 
                                        class="px-1.5 text-gray-400 hover:text-black text-xs font-bold"
                                    >+</button>
                                </div>

                                <!-- Remove -->
                                <button 
                                    @click="removeFromCart(idx)" 
                                    class="text-[10px] text-gray-400 hover:text-red-600 uppercase tracking-wider underline cursor-pointer"
                                >
                                    Remove
                                </button>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Drawer Footer (Subtotal & Checkout) -->
            <div x-show="cart.length > 0" class="border-t border-gray-100 px-6 py-5 bg-neutral-50/50 space-y-3 font-sans">
                <div class="flex items-center justify-between text-xs font-bold uppercase tracking-wider text-black">
                    <span>Subtotal</span>
                    <span>PKR <span x-text="cartSubtotal.toLocaleString()"></span></span>
                </div>
                <p class="text-[10px] text-gray-400">Shipping and discounts calculated at checkout.</p>
                <div class="space-y-2 pt-1">
                    <a 
                        href="{{ route('storefront.checkout') }}" 
                        class="block w-full text-center bg-black hover:bg-neutral-800 text-white text-xs font-bold uppercase tracking-[0.2em] py-3.5 rounded-lg shadow-md transition-all cursor-pointer"
                    >
                        Proceed to Checkout
                    </a>
                    <button 
                        @click="isCartOpen = false" 
                        class="block w-full text-center text-[10px] text-neutral-500 hover:text-black uppercase tracking-widest pt-1"
                    >
                        Continue Shopping
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
