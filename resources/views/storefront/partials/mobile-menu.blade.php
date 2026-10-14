<!-- Mobile Drawer Navigation -->
<div 
    x-show="mobileMenuOpen" 
    x-cloak 
    class="fixed inset-0 z-50 overflow-hidden lg:hidden" 
    role="dialog" 
    aria-modal="true"
>
    <!-- Background Backdrop Overlay -->
    <div 
        x-show="mobileMenuOpen"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-black/75 backdrop-blur-xs transition-opacity" 
        @click="mobileMenuOpen = false"
    ></div>

    <!-- Slide-over Drawer Panel -->
    <div class="fixed inset-y-0 left-0 max-w-full flex pr-10">
        <div 
            x-show="mobileMenuOpen"
            x-transition:enter="transform transition ease-out duration-300"
            x-transition:enter-start="-translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transform transition ease-in duration-200"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
            class="w-screen max-w-xs sm:max-w-sm bg-neutral-950 text-white shadow-2xl flex flex-col justify-between border-r border-white/10"
        >
            <!-- Drawer Header -->
            <div class="px-5 py-4 border-b border-white/10 flex items-center justify-between bg-black/40">
                <div class="border border-white/30 px-3 py-1 bg-black/60 rounded-[2px]">
                    <span class="font-serif font-bold text-xs uppercase tracking-[0.25em] text-white">
                        {{ !empty($settings['web_site_name']) ? strtoupper($settings['web_site_name']) : 'TRENDHUB' }}
                    </span>
                </div>
                <button 
                    @click="mobileMenuOpen = false" 
                    class="p-2 text-gray-400 hover:text-white transition-colors cursor-pointer rounded-full hover:bg-white/10"
                    aria-label="Close menu"
                >
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <!-- Drawer Body / Nav Links -->
            <div class="flex-1 overflow-y-auto px-5 py-6 space-y-6 scrollbar-none">
                <nav class="flex flex-col space-y-1 text-xs font-sans font-bold uppercase tracking-[0.18em]">
                    <a 
                        href="{{ route('storefront.home') }}" 
                        @click="mobileMenuOpen = false"
                        class="py-3 px-3 rounded hover:bg-white/5 hover:text-indigo-400 transition-colors border-b border-white/5 flex items-center justify-between"
                    >
                        <span>Home</span>
                        <span class="text-white/30 text-[10px]">&rarr;</span>
                    </a>
                    <a 
                        href="{{ route('storefront.shop') }}" 
                        @click="mobileMenuOpen = false"
                        class="py-3 px-3 rounded hover:bg-white/5 hover:text-indigo-400 transition-colors border-b border-white/5 flex items-center justify-between"
                    >
                        <span>All Collections</span>
                        <span class="text-white/30 text-[10px]">&rarr;</span>
                    </a>
                    <a 
                        href="{{ route('storefront.shop', ['tag' => 'New Arrival']) }}" 
                        @click="mobileMenuOpen = false"
                        class="py-3 px-3 rounded hover:bg-white/5 hover:text-indigo-400 transition-colors border-b border-white/5 flex items-center justify-between"
                    >
                        <span>New Arrivals</span>
                        <span class="bg-indigo-600 text-white text-[8px] px-1.5 py-0.5 rounded font-mono">NEW</span>
                    </a>
                    <a 
                        href="{{ route('storefront.shop', ['tag' => 'Best Seller']) }}" 
                        @click="mobileMenuOpen = false"
                        class="py-3 px-3 rounded hover:bg-white/5 hover:text-indigo-400 transition-colors border-b border-white/5 flex items-center justify-between"
                    >
                        <span>Best Sellers</span>
                        <span class="bg-amber-600 text-white text-[8px] px-1.5 py-0.5 rounded font-mono">HOT</span>
                    </a>
                    <a 
                        href="{{ route('storefront.store_locator') }}" 
                        @click="mobileMenuOpen = false"
                        class="py-3 px-3 rounded hover:bg-white/5 hover:text-indigo-400 transition-colors border-b border-white/5 flex items-center justify-between"
                    >
                        <span>Store Locator</span>
                        <span class="text-white/30 text-[10px]">&rarr;</span>
                    </a>
                    <a 
                        href="{{ route('storefront.wishlist') }}" 
                        @click="mobileMenuOpen = false"
                        class="py-3 px-3 rounded hover:bg-white/5 hover:text-indigo-400 transition-colors border-b border-white/5 flex items-center justify-between"
                    >
                        <span>Wishlist</span>
                        <span x-show="wishlist.length > 0" x-text="wishlist.length" class="bg-indigo-600 text-white text-[9px] px-2 py-0.5 rounded-full font-bold"></span>
                    </a>
                    <a 
                        href="{{ url('/software') }}" 
                        class="py-3 px-3 rounded hover:bg-white/5 text-indigo-400 hover:text-indigo-300 transition-colors border-b border-white/5 flex items-center justify-between"
                    >
                        <span>Customer Login / Portal</span>
                        <span class="text-indigo-400 text-[10px]">&rarr;</span>
                    </a>
                </nav>

                <!-- Quick Action Buttons inside drawer -->
                <div class="pt-2 flex flex-col gap-2">
                    <button 
                        @click="mobileMenuOpen = false; isCartOpen = true" 
                        class="w-full bg-[#4F46E5] hover:bg-[#4338CA] text-white py-2.5 rounded text-[10px] uppercase font-bold tracking-[0.2em] flex items-center justify-center gap-2 cursor-pointer transition-colors"
                    >
                        <i data-lucide="shopping-bag" class="w-4 h-4"></i>
                        <span>Open Bag (<span x-text="cartCount">0</span>)</span>
                    </button>
                    <button 
                        @click="mobileMenuOpen = false; searchModalOpen = true" 
                        class="w-full bg-white/10 hover:bg-white/20 text-white py-2.5 rounded text-[10px] uppercase font-bold tracking-[0.2em] flex items-center justify-center gap-2 cursor-pointer transition-colors border border-white/15"
                    >
                        <i data-lucide="search" class="w-4 h-4"></i>
                        <span>Search Catalog</span>
                    </button>
                </div>
            </div>

            <!-- Drawer Footer Support -->
            <div class="p-5 border-t border-white/10 bg-black/40 space-y-2 text-[11px] text-gray-400">
                <p class="font-bold text-white uppercase tracking-wider text-xs">Customer Support</p>
                <div class="flex items-center gap-2">
                    <span class="text-white/60">WhatsApp:</span>
                    <a href="https://wa.me/92{{ ltrim($settings['web_whatsapp_number'] ?? '3173340926', '0') }}" target="_blank" class="text-indigo-400 hover:underline">
                        +92 {{ ltrim($settings['web_whatsapp_number'] ?? '3173340926', '0') }}
                    </a>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-white/60">Email:</span>
                    <a href="mailto:{{ $settings['web_contact_email'] ?? 'trendhubstorepk1@gmail.com' }}" class="text-gray-300 hover:underline">
                        {{ $settings['web_contact_email'] ?? 'trendhubstorepk1@gmail.com' }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
