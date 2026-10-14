@extends('storefront.layout')

@section('title', 'Order Placed Successfully | ' . ($settings['web_site_name'] ?? 'TrendHub'))

@section('content')
<div class="bg-white min-h-[75vh] flex items-center justify-center py-16 px-4 font-sans" x-init="localStorage.removeItem('th_cart'); cart = [];">
    <div class="max-w-xl w-full text-center space-y-6 bg-neutral-50/50 p-8 sm:p-12 rounded-3xl border border-gray-100 shadow-xs">
        
        <div class="w-16 h-16 bg-emerald-100 text-emerald-800 rounded-full flex items-center justify-center mx-auto shadow-xs">
            <i data-lucide="check" class="w-8 h-8 stroke-[2.5]"></i>
        </div>

        <div class="space-y-1">
            <span class="text-[10px] sm:text-xs font-bold uppercase tracking-[0.25em] text-emerald-700">ORDER CONFIRMED</span>
            <h1 class="font-serif text-2xl sm:text-3xl font-light uppercase text-black tracking-wide">
                Thank You, {{ $order->shipping_name }}!
            </h1>
            <p class="text-xs text-gray-500 pt-1">
                Your order has been recorded in our system. You will receive a verification SMS / Call shortly.
            </p>
        </div>

        <!-- Order Info Card -->
        <div class="bg-white rounded-2xl p-6 border border-gray-100 text-left text-xs space-y-3 font-sans">
            <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                <span class="text-gray-400 uppercase tracking-wider">Order Tracking No:</span>
                <span class="font-mono font-bold text-black text-sm">{{ $order->order_number }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-gray-400">Payment Mode:</span>
                <span class="font-semibold text-black uppercase">{{ $order->payment_method }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-gray-400">Ship To:</span>
                <span class="text-neutral-800 font-medium truncate max-w-[220px]">{{ $order->shipping_city }} ({{ $order->shipping_phone }})</span>
            </div>
            <div class="flex justify-between items-center pt-2 border-t border-gray-100 text-sm font-bold">
                <span>Total Amount:</span>
                <span class="font-mono text-black">PKR {{ number_format($order->total_amount) }}</span>
            </div>
        </div>

        <!-- Actions -->
        <div class="space-y-3 pt-2">
            <a 
                href="{{ route('storefront.shop') }}" 
                class="inline-block w-full bg-black hover:bg-neutral-800 text-white text-xs font-bold uppercase tracking-[0.2em] py-3.5 rounded-xl transition-all"
            >
                Continue Shopping
            </a>
            
            @php
                $rawPh = $settings['web_whatsapp_number'] ?? '3173340926';
                $cleanPh = preg_replace('/[^0-9]/', '', $rawPh);
                if (!str_starts_with($cleanPh, '92')) $cleanPh = '92' . ltrim($cleanPh, '0');
                $waText = "Assalam-o-Alaikum, I just placed order #{$order->order_number} for PKR " . number_format($order->total_amount) . ". Kindly confirm dispatch.";
            @endphp
            <a 
                href="https://wa.me/{{ $cleanPh }}?text={{ urlencode($waText) }}" 
                target="_blank"
                class="inline-flex items-center justify-center gap-2 w-full border border-emerald-600 text-emerald-700 hover:bg-emerald-50 text-xs font-bold uppercase tracking-wider py-3 rounded-xl transition-all"
            >
                <i data-lucide="message-circle" class="w-4 h-4 fill-emerald-600 stroke-none"></i>
                Track on WhatsApp
            </a>
        </div>
    </div>
</div>
@endsection
