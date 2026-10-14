@extends('storefront.layout')

@section('title', 'Store Locator | ' . ($settings['web_site_name'] ?? 'TrendHub'))

@section('content')
<div class="bg-white min-h-[70vh] py-12 px-4 sm:px-6 lg:px-8 font-sans">
    <div class="max-w-[1200px] mx-auto space-y-10">
        
        <div class="text-center space-y-1">
            <span class="text-[10px] font-sans font-bold tracking-[0.25em] uppercase text-gray-400">FIND US IN PERSON</span>
            <h1 class="font-serif text-3xl sm:text-4xl uppercase tracking-wide font-normal text-neutral-900">
                Flagship Store
            </h1>
            <p class="text-xs text-gray-400 max-w-md mx-auto">
                Visit our boutique showroom to experience our luxury fabrics, tailored cuts, and personal styling consultations.
            </p>
        </div>

        @if(!empty($settings['web_store_locator_banner_image']))
            <div class="w-full h-64 sm:h-80 rounded-3xl overflow-hidden shadow-sm">
                <img 
                    src="{{ asset($settings['web_store_locator_banner_image']) }}" 
                    alt="Store Banner" 
                    class="w-full h-full object-cover"
                >
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">
            <!-- Store Details Card -->
            <div class="bg-neutral-50 p-8 rounded-3xl border border-gray-100 space-y-5">
                <h3 class="font-serif text-xl font-bold uppercase tracking-wider text-black">
                    {{ $settings['company_name'] ?? ($settings['web_site_name'] ?? 'TrendHub Store') }}
                </h3>
                
                <div class="space-y-4 text-xs text-gray-600">
                    <div class="flex items-start gap-3">
                        <i data-lucide="map-pin" class="w-4 h-4 text-black mt-0.5 shrink-0"></i>
                        <span>
                            {{ $settings['company_address'] ?? 'Shop no 54 Shaheen Arcade unit #8 Latifabad Hyderabad' }}
                        </span>
                    </div>

                    <div class="flex items-center gap-3">
                        <i data-lucide="phone" class="w-4 h-4 text-black shrink-0"></i>
                        <span>+92 {{ ltrim($settings['company_phone'] ?? '03173340926', '0') }}</span>
                    </div>

                    <div class="flex items-center gap-3">
                        <i data-lucide="clock" class="w-4 h-4 text-black shrink-0"></i>
                        <span>Monday – Saturday: 11:00 AM – 11:00 PM (Sunday Closed)</span>
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-200">
                    @php
                        $cleanPh = preg_replace('/[^0-9]/', '', $settings['web_whatsapp_number'] ?? '03173340926');
                        if (!str_starts_with($cleanPh, '92')) $cleanPh = '92' . ltrim($cleanPh, '0');
                    @endphp
                    <a 
                        href="https://wa.me/{{ $cleanPh }}?text={{ urlencode('Assalam-o-Alaikum, I want directions to your store showroom.') }}" 
                        target="_blank"
                        class="inline-flex items-center gap-2 bg-black hover:bg-neutral-800 text-white text-xs font-bold uppercase tracking-wider px-6 py-3 rounded-full transition-all"
                    >
                        <i data-lucide="navigation" class="w-4 h-4"></i> Get Directions on WhatsApp
                    </a>
                </div>
            </div>

            <!-- Store Experience Notice -->
            <div class="p-8 rounded-3xl border border-gray-100 space-y-4 text-xs text-gray-500 leading-relaxed">
                <h4 class="font-bold text-sm uppercase tracking-wider text-black">The In-Store Experience</h4>
                <p>
                    Step into our space designed for the modern sartorial connoisseur. Browse our complete ready-to-wear racks, feel the hand-feel of our breathable summer lycras and winter textured weaves, and get fitted on spot.
                </p>
                <div class="pt-4 space-y-2">
                    <p class="font-bold text-black uppercase tracking-wider text-[11px]">Services Available In-Store:</p>
                    <ul class="list-disc pl-5 space-y-1">
                        <li>Complimentary size fitting and consultations</li>
                        <li>Direct exchange and instant pickup</li>
                        <li>Cash, Debit Card & Mobile wallet payment support</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
