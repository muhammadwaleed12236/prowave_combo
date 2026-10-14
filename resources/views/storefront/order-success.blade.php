@extends('storefront.layout')

@section('title', 'Order Placed Successfully | ' . ($settings['web_site_name'] ?? 'TrendHub'))

@section('content')
<div class="bg-white min-h-[75vh] flex flex-col items-center justify-center py-16 px-4 font-sans select-none" x-init="localStorage.removeItem('th_cart'); cart = [];">
    <div class="max-w-lg w-full text-center space-y-6">
        
        <!-- Big Checkmark in Circle -->
        <div class="w-16 h-16 border-2 border-black rounded-full flex items-center justify-center mx-auto">
            <i data-lucide="check" class="w-8 h-8 text-black stroke-[2.5]"></i>
        </div>

        <div class="space-y-2">
            <h1 class="font-serif text-2xl sm:text-3xl md:text-4xl uppercase tracking-[0.15em] text-black font-normal">
                ORDER PLACED SUCCESSFULLY!
            </h1>
            <p class="font-serif italic text-sm text-gray-500">
                Thank you for shopping with {{ $settings['web_site_name'] ?? 'TrendHub' }}. Your order has been registered.
            </p>
        </div>

        <!-- Order Info Card -->
        <div class="bg-[#f9fafb] p-6 sm:p-8 rounded-sm text-left text-xs sm:text-sm space-y-3 font-sans border border-gray-100 max-w-md mx-auto">
            <div class="flex justify-between items-center pb-2">
                <span class="text-gray-400">Order Number:</span>
                <span class="font-mono font-bold text-black">{{ $order->order_number }}</span>
            </div>
            <div class="flex justify-between items-center pb-2">
                <span class="text-gray-400">Total Amount:</span>
                <span class="font-bold text-black font-sans">Rs. {{ number_format($order->total) }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-gray-400">Payment Mode:</span>
                <span class="font-bold text-black uppercase">{{ $order->payment_method }}</span>
            </div>
        </div>

        <!-- Actions -->
        <div class="pt-4 flex flex-col sm:flex-row items-center justify-center gap-3">
            <a 
                href="{{ route('storefront.shop') }}" 
                class="bg-black hover:bg-neutral-800 text-white text-xs font-sans font-bold uppercase tracking-[0.2em] px-8 py-3.5 transition-all inline-block hover:scale-105 shadow-sm"
            >
                CONTINUE SHOPPING
            </a>

            @php
                $rawPh = $settings['web_whatsapp_number'] ?? '3173340926';
                $cleanPh = preg_replace('/[^0-9]/', '', $rawPh);
                if (!str_starts_with($cleanPh, '92')) $cleanPh = '92' . ltrim($cleanPh, '0');
                $waText = "Assalam-o-Alaikum, I placed order #{$order->order_number} for Rs. " . number_format($order->total) . ". Kindly confirm dispatch.";
            @endphp
            <a 
                href="https://wa.me/{{ $cleanPh }}?text={{ urlencode($waText) }}" 
                target="_blank"
                class="border border-emerald-600 text-emerald-700 hover:bg-emerald-50 text-xs font-sans font-bold uppercase tracking-wider px-6 py-3.5 transition-all inline-flex items-center gap-2"
            >
                <i data-lucide="message-circle" class="w-4 h-4 fill-emerald-600 stroke-none"></i>
                <span>Track on WhatsApp</span>
            </a>
        </div>
    </div>
</div>
@endsection
