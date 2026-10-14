<footer class="bg-[#fafafa] border-t border-gray-100 text-[#111111] pt-16 pb-12 font-sans select-none">
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
        
        <!-- Brand Story Column -->
        <div class="space-y-4 lg:col-span-1 pr-4">
            <h4 class="font-serif text-xl tracking-[0.2em] font-bold uppercase text-neutral-900">
                {{ $settings['web_site_name'] ?? 'TREND HUB' }}
            </h4>
            <p class="text-[13px] text-gray-500 font-sans leading-relaxed">
                {{ !empty($settings['web_about_us']) ? $settings['web_about_us'] : 'Dedicated to elevated menswear fashion. Redefining modern luxury with clean tailoring, refined cuts, and premium fabrics built for every season.' }}
            </p>
            <div class="pt-2 flex items-center gap-4 text-neutral-600">
                @if(!empty($settings['web_instagram_link']))
                    <a href="{{ $settings['web_instagram_link'] }}" target="_blank" class="hover:text-black transition-colors" aria-label="Instagram">
                        <i data-lucide="instagram" class="w-4 h-4"></i>
                    </a>
                @endif
                @if(!empty($settings['web_facebook_link']))
                    <a href="{{ $settings['web_facebook_link'] }}" target="_blank" class="hover:text-black transition-colors" aria-label="Facebook">
                        <i data-lucide="facebook" class="w-4 h-4"></i>
                    </a>
                @endif
                @if(!empty($settings['web_tiktok_link']))
                    <a href="{{ $settings['web_tiktok_link'] }}" target="_blank" class="hover:text-black transition-colors" aria-label="TikTok">
                        <i data-lucide="video" class="w-4 h-4"></i>
                    </a>
                @endif
            </div>
        </div>

        <!-- Quick Links -->
        <div class="space-y-4">
            <h5 class="text-[11px] font-bold uppercase tracking-[0.2em] text-gray-400">Collections</h5>
            <ul class="space-y-2.5 text-[13px] text-gray-600 font-sans">
                <li><a href="{{ route('storefront.shop') }}" class="hover:text-black transition-colors">All Products</a></li>
                <li><a href="{{ route('storefront.shop', ['tag' => 'New Arrival']) }}" class="hover:text-black transition-colors">New Arrivals</a></li>
                <li><a href="{{ route('storefront.shop', ['tag' => 'Best Seller']) }}" class="hover:text-black transition-colors">Best Sellers</a></li>
                <li><a href="{{ route('storefront.shop', ['category' => 'SHIRTS']) }}" class="hover:text-black transition-colors">Formal & Casual Shirts</a></li>
                <li><a href="{{ route('storefront.shop', ['category' => 'TROUSERS']) }}" class="hover:text-black transition-colors">Trousers & Chinos</a></li>
            </ul>
        </div>

        <!-- Client Care & Policies -->
        <div class="space-y-4">
            <h5 class="text-[11px] font-bold uppercase tracking-[0.2em] text-gray-400">Client Service</h5>
            <ul class="space-y-2.5 text-[13px] text-gray-600 font-sans">
                <li><a href="{{ route('storefront.store_locator') }}" class="hover:text-black transition-colors">Store Locator</a></li>
                <li><a href="{{ route('storefront.wishlist') }}" class="hover:text-black transition-colors">My Wishlist</a></li>
                <li>
                    @php
                        $rawPh = $settings['web_contact_phone'] ?? '03173340926';
                        $cleanPh = preg_replace('/[^0-9]/', '', $rawPh);
                    @endphp
                    <a href="tel:+92{{ ltrim($cleanPh, '0') }}" class="hover:text-black transition-colors">
                        Helpline: +92 {{ ltrim($cleanPh, '0') }}
                    </a>
                </li>
                <li>
                    <a href="mailto:{{ $settings['web_contact_email'] ?? 'trendhubstorepk1@gmail.com' }}" class="hover:text-black transition-colors">
                        {{ $settings['web_contact_email'] ?? 'trendhubstorepk1@gmail.com' }}
                    </a>
                </li>
                <li><span class="text-neutral-400">Shipping: Nationwide Express (2-4 Days)</span></li>
            </ul>
        </div>

        <!-- Newsletter & Payment Badges -->
        <div class="space-y-4">
            <h5 class="text-[11px] font-bold uppercase tracking-[0.2em] text-gray-400">Newsletter</h5>
            <p class="text-[13px] text-gray-500 leading-relaxed font-sans">
                Subscribe to receive updates on seasonal collections, private sales, and exclusive drops.
            </p>
            <form onsubmit="event.preventDefault(); alert('Thank you for subscribing to TrendHub.'); this.reset();" class="flex border-b border-black py-1">
                <input 
                    type="email" 
                    placeholder="ENTER YOUR EMAIL" 
                    class="bg-transparent text-[11px] uppercase tracking-wider focus:outline-none w-full text-black placeholder-gray-400 font-sans"
                    required
                >
                <button type="submit" class="text-black hover:opacity-50 transition-opacity p-1">
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </button>
            </form>
            <div class="pt-2 text-[10px] text-gray-400 uppercase tracking-widest flex items-center gap-3">
                <span>Cash on Delivery</span>
                <span>&bull;</span>
                <span>EasyPaisa</span>
                <span>&bull;</span>
                <span>Bank Transfer</span>
            </div>
        </div>
    </div>

    <!-- Bottom Copyright -->
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 border-t border-gray-100 mt-16 pt-8 flex flex-col sm:flex-row justify-between items-center gap-4 text-xs text-gray-400 font-sans">
        <span>&copy; {{ date('Y') }} {{ $settings['web_site_name'] ?? 'TrendHub Store' }}. All Rights Reserved.</span>
        <span class="tracking-wider uppercase text-[10px]">Pure Craftsmanship &bull; Elevated Luxury Menswear</span>
    </div>
</footer>
