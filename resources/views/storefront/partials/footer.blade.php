<!-- Luxury Dark Footer (Reference Match: 5 Columns) -->
<footer class="bg-[#0d0d0d] text-gray-400 pt-16 pb-10 font-sans text-xs select-none border-t border-neutral-900">
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10">
        
        <!-- Column 1: Brand Info -->
        <div class="space-y-4">
            <a href="{{ route('storefront.home') }}" class="flex items-center gap-2 group">
                <div class="border-2 border-white px-2 py-0.5 font-serif font-black text-xl tracking-tighter text-white">
                    {{ strtoupper(substr($settings['web_site_name'] ?? 'NB', 0, 2)) }}
                </div>
                <div class="flex flex-col">
                    <span class="font-serif font-black text-base tracking-[0.2em] uppercase leading-none text-white">
                        {{ $settings['web_site_name'] ?? "NB MEN'S WEAR" }}
                    </span>
                    <span class="text-[8px] font-sans font-bold tracking-[0.35em] uppercase text-[#b89758] leading-tight">
                        MEN'S WEAR
                    </span>
                </div>
            </a>
            <p class="text-xs text-gray-400 leading-relaxed">
                {{ !empty($settings['web_about_us']) ? $settings['web_about_us'] : "Premium men's clothing for modern lifestyle. Quality, comfort and style — all in one place." }}
            </p>
            <div class="pt-2 flex items-center gap-3.5 text-gray-300">
                <a href="{{ $settings['web_facebook_link'] ?? '#' }}" target="_blank" class="hover:text-white transition-colors" aria-label="Facebook">
                    <i data-lucide="facebook" class="w-4 h-4"></i>
                </a>
                <a href="{{ $settings['web_instagram_link'] ?? '#' }}" target="_blank" class="hover:text-white transition-colors" aria-label="Instagram">
                    <i data-lucide="instagram" class="w-4 h-4"></i>
                </a>
                <a href="{{ $settings['web_tiktok_link'] ?? '#' }}" target="_blank" class="hover:text-white transition-colors" aria-label="TikTok">
                    <i data-lucide="video" class="w-4 h-4"></i>
                </a>
                <a href="#" class="hover:text-white transition-colors" aria-label="YouTube">
                    <i data-lucide="youtube" class="w-4 h-4"></i>
                </a>
            </div>
        </div>

        <!-- Column 2: Quick Links -->
        <div class="space-y-3">
            <h5 class="text-xs font-bold uppercase tracking-wider text-white">Quick Links</h5>
            <ul class="space-y-2 text-gray-400">
                <li><a href="{{ route('storefront.home') }}" class="hover:text-white transition-colors">Home</a></li>
                <li><a href="{{ route('storefront.shop', ['category' => 'TROUSERS']) }}" class="hover:text-white transition-colors">Trousers</a></li>
                <li><a href="{{ route('storefront.shop', ['category' => 'SHIRTS']) }}" class="hover:text-white transition-colors">Shirts</a></li>
                <li><a href="{{ route('storefront.shop', ['category' => 'T-SHIRTS']) }}" class="hover:text-white transition-colors">T-Shirts</a></li>
                <li><a href="{{ route('storefront.shop', ['category' => 'JEANS']) }}" class="hover:text-white transition-colors">Jeans</a></li>
                <li><a href="{{ route('storefront.shop', ['tag' => 'New Arrival']) }}" class="hover:text-white transition-colors">New Arrivals</a></li>
                <li><a href="{{ route('storefront.shop', ['tag' => 'Sale']) }}" class="hover:text-white transition-colors">Sale</a></li>
            </ul>
        </div>

        <!-- Column 3: Customer Care -->
        <div class="space-y-3">
            <h5 class="text-xs font-bold uppercase tracking-wider text-white">Customer Care</h5>
            <ul class="space-y-2 text-gray-400">
                <li><a href="{{ route('storefront.checkout') }}" class="hover:text-white transition-colors">Track Order</a></li>
                <li><a href="#" class="hover:text-white transition-colors">Shipping Policy</a></li>
                <li><a href="#" class="hover:text-white transition-colors">Return & Exchange</a></li>
                <li><a href="#" class="hover:text-white transition-colors">Size Guide</a></li>
                <li><a href="#" class="hover:text-white transition-colors">FAQs</a></li>
                <li><a href="{{ route('storefront.store_locator') }}" class="hover:text-white transition-colors">Contact Us</a></li>
            </ul>
        </div>

        <!-- Column 4: About Us -->
        <div class="space-y-3">
            <h5 class="text-xs font-bold uppercase tracking-wider text-white">About Us</h5>
            <ul class="space-y-2 text-gray-400">
                <li><a href="#" class="hover:text-white transition-colors">Our Story</a></li>
                <li><a href="#" class="hover:text-white transition-colors">Why Choose Us</a></li>
                <li><a href="#" class="hover:text-white transition-colors">Terms & Conditions</a></li>
                <li><a href="#" class="hover:text-white transition-colors">Privacy Policy</a></li>
            </ul>
        </div>

        <!-- Column 5: Contact Info -->
        <div class="space-y-3">
            <h5 class="text-xs font-bold uppercase tracking-wider text-white">Contact Info</h5>
            <div class="space-y-2 text-gray-400">
                <div class="flex items-center gap-2">
                    <i data-lucide="mail" class="w-4 h-4 text-[#b89758]"></i>
                    <a href="mailto:{{ $settings['web_contact_email'] ?? 'trendhubstorepk1@gmail.com' }}" class="hover:text-white transition-colors">
                        {{ $settings['web_contact_email'] ?? 'trendhubstorepk1@gmail.com' }}
                    </a>
                </div>
                <div class="flex items-center gap-2">
                    <i data-lucide="clock" class="w-4 h-4 text-[#b89758]"></i>
                    <span>Mon - Sat: 9:00 AM - 9:00 PM</span>
                </div>
                <div class="flex items-center gap-2">
                    <i data-lucide="map-pin" class="w-4 h-4 text-[#b89758]"></i>
                    <span>{{ $settings['web_contact_address'] ?? 'Pakistan' }}</span>
                </div>
            </div>

            <div class="pt-3">
                <span class="text-[10px] uppercase font-bold text-gray-400 block mb-1.5">Payment Methods</span>
                <div class="flex items-center gap-2">
                    <span class="bg-white text-black font-bold text-[9px] px-2 py-0.5 rounded">VISA</span>
                    <span class="bg-red-600 text-white font-bold text-[9px] px-2 py-0.5 rounded">Mastercard</span>
                    <span class="bg-[#b89758] text-black font-bold text-[9px] px-2 py-0.5 rounded">COD</span>
                </div>
            </div>
        </div>

    </div>

    <!-- Bottom Copyright -->
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 border-t border-neutral-800 mt-12 pt-6 flex flex-col sm:flex-row justify-between items-center gap-4 text-xs text-gray-500">
        <span>&copy; {{ date('Y') }} {{ $settings['web_site_name'] ?? 'TrendHub' }} Men's Wear. All Rights Reserved.</span>
        <span>Crafted for Modern Elegance</span>
    </div>
</footer>
