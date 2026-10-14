@extends('storefront.layout')

@section('title', 'Secure Checkout | ' . ($settings['web_site_name'] ?? 'TrendHub'))

@section('content')
<div 
    class="bg-[#fafafa] min-h-screen py-10 sm:py-16 font-sans" 
    x-data="{
        paymentMethod: '{{ old('payment_method', 'COD') }}'
    }"
    x-init="
        $nextTick(() => {
            const raw = localStorage.getItem('th_cart');
            const el = document.getElementById('cart_data_input');
            if (raw && el) {
                el.value = raw;
            }
        });
    "
>
    <div class="max-w-[1200px] mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="text-center mb-10">
            <span class="text-[10px] sm:text-[11px] font-sans font-bold tracking-[0.25em] uppercase text-gray-400">
                EXPRESS CHECKOUT
            </span>
            <h1 class="font-serif text-3xl sm:text-4xl uppercase tracking-wide font-normal text-neutral-900 mt-1">
                Complete Your Order
            </h1>
        </div>

        @if(isset($errors) && $errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 text-xs rounded-xl">
                <div class="font-bold uppercase tracking-wider mb-1 flex items-center gap-1.5">
                    <i data-lucide="alert-circle" class="w-4 h-4 text-red-600"></i> Attention:
                </div>
                <ul class="list-disc pl-5 space-y-1">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Empty Cart Notice -->
        <template x-if="cart.length === 0">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center max-w-lg mx-auto space-y-4">
                <i data-lucide="shopping-bag" class="w-12 h-12 text-gray-300 mx-auto"></i>
                <h3 class="text-base font-bold uppercase tracking-wider text-black">Your bag is currently empty</h3>
                <p class="text-xs text-gray-400">You must add at least one item to your bag before proceeding to checkout.</p>
                <a href="{{ route('storefront.shop') }}" class="inline-block bg-black text-white text-xs font-bold uppercase tracking-widest px-8 py-3 rounded-full hover:bg-neutral-800 transition-all">
                    Explore Collections
                </a>
            </div>
        </template>

        <!-- Checkout Grid Form -->
        <template x-if="cart.length > 0">
            <form 
                action="{{ route('storefront.place_order') }}" 
                method="POST" 
                enctype="multipart/form-data"
                id="checkoutForm"
                @submit="
                    const rawData = localStorage.getItem('th_cart') || JSON.stringify(cart || []);
                    let parsedItems = [];
                    try { parsedItems = JSON.parse(rawData); } catch(e) {}
                    if (!parsedItems || parsedItems.length === 0) {
                        alert('Your bag is currently empty. Please add items to your cart first.');
                        $event.preventDefault();
                        return false;
                    }
                    document.getElementById('cart_data_input').value = rawData;
                "
                class="grid grid-cols-1 lg:grid-cols-12 gap-8 sm:gap-12"
            >
                @csrf
                <input 
                    type="hidden" 
                    id="cart_data_input" 
                    name="cart_data" 
                    :value="JSON.stringify(cart)"
                >

                <!-- Left Column: Shipping & Payment (7 cols) -->
                <div class="lg:col-span-7 space-y-8">
                    
                    <!-- 1. Shipping Details -->
                    <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-xs border border-gray-100 space-y-5">
                        <h2 class="text-sm font-bold uppercase tracking-[0.2em] text-neutral-900 border-b border-gray-100 pb-3 flex items-center gap-2">
                            <i data-lucide="map-pin" class="w-4 h-4 text-black"></i> 1. Shipping Information
                        </h2>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                            <div class="space-y-1.5 sm:col-span-2">
                                <label class="font-bold uppercase tracking-wider text-neutral-700">Full Name *</label>
                                <input 
                                    type="text" 
                                    name="shipping_name" 
                                    value="{{ old('shipping_name') }}"
                                    required 
                                    placeholder="e.g. Muhammad Ali" 
                                    class="w-full border border-gray-200 rounded-lg p-3 text-sm focus:outline-none focus:border-black font-sans"
                                >
                            </div>

                            <div class="space-y-1.5">
                                <label class="font-bold uppercase tracking-wider text-neutral-700">WhatsApp / Mobile Number *</label>
                                <input 
                                    type="tel" 
                                    name="shipping_phone" 
                                    value="{{ old('shipping_phone') }}"
                                    required 
                                    placeholder="03XXXXXXXXX" 
                                    class="w-full border border-gray-200 rounded-lg p-3 text-sm focus:outline-none focus:border-black font-mono"
                                >
                            </div>

                            <div class="space-y-1.5">
                                <label class="font-bold uppercase tracking-wider text-neutral-700">City *</label>
                                <input 
                                    type="text" 
                                    name="shipping_city" 
                                    value="{{ old('shipping_city') }}"
                                    required 
                                    placeholder="Karachi, Lahore, Islamabad, etc." 
                                    class="w-full border border-gray-200 rounded-lg p-3 text-sm focus:outline-none focus:border-black"
                                >
                            </div>

                            <div class="space-y-1.5 sm:col-span-2">
                                <label class="font-bold uppercase tracking-wider text-neutral-700">Delivery Address *</label>
                                <textarea 
                                    name="shipping_address" 
                                    required 
                                    rows="2"
                                    placeholder="House / Apartment no, Street, Sector, Area..." 
                                    class="w-full border border-gray-200 rounded-lg p-3 text-sm focus:outline-none focus:border-black font-sans"
                                >{{ old('shipping_address') }}</textarea>
                            </div>

                            <div class="space-y-1.5 sm:col-span-2">
                                <label class="font-bold uppercase tracking-wider text-neutral-700">Email Address (Optional)</label>
                                <input 
                                    type="email" 
                                    name="shipping_email" 
                                    value="{{ old('shipping_email') }}"
                                    placeholder="For order confirmation receipt" 
                                    class="w-full border border-gray-200 rounded-lg p-3 text-sm focus:outline-none focus:border-black font-sans"
                                >
                            </div>

                            <div class="space-y-1.5 sm:col-span-2">
                                <label class="font-bold uppercase tracking-wider text-neutral-700">Special Delivery Instructions (Optional)</label>
                                <input 
                                    type="text" 
                                    name="order_notes" 
                                    value="{{ old('order_notes') }}"
                                    placeholder="e.g. Call before delivery, deliver after 2 PM" 
                                    class="w-full border border-gray-200 rounded-lg p-3 text-sm focus:outline-none focus:border-black font-sans"
                                >
                            </div>
                        </div>
                    </div>

                    <!-- 2. Payment Method -->
                    <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-xs border border-gray-100 space-y-5">
                        <h2 class="text-sm font-bold uppercase tracking-[0.2em] text-neutral-900 border-b border-gray-100 pb-3 flex items-center gap-2">
                            <i data-lucide="credit-card" class="w-4 h-4 text-black"></i> 2. Payment Method
                        </h2>

                        <div class="space-y-3 text-xs font-sans">
                            <!-- COD Option -->
                            <label class="flex items-center gap-3 p-4 rounded-xl border cursor-pointer transition-all" :class="paymentMethod === 'COD' ? 'border-black bg-neutral-50 shadow-xs' : 'border-gray-200 hover:border-gray-300'">
                                <input type="radio" name="payment_method" value="COD" x-model="paymentMethod" class="text-black focus:ring-black">
                                <div class="flex-1">
                                    <span class="font-bold uppercase tracking-wider text-black block">Cash on Delivery (COD)</span>
                                    <span class="text-gray-500 text-[11px]">Pay in cash when rider delivers to your doorstep.</span>
                                </div>
                            </label>

                            <!-- EasyPaisa Option -->
                            <label class="flex items-center gap-3 p-4 rounded-xl border cursor-pointer transition-all" :class="paymentMethod === 'Easypaisa' ? 'border-black bg-neutral-50 shadow-xs' : 'border-gray-200 hover:border-gray-300'">
                                <input type="radio" name="payment_method" value="Easypaisa" x-model="paymentMethod" class="text-black focus:ring-black">
                                <div class="flex-1">
                                    <span class="font-bold uppercase tracking-wider text-black block">EasyPaisa Mobile Account</span>
                                    <span class="text-gray-500 text-[11px]">Direct transfer to our official EasyPaisa wallet.</span>
                                </div>
                            </label>

                            <!-- EasyPaisa Detail Box -->
                            <div x-show="paymentMethod === 'Easypaisa'" class="p-4 bg-emerald-50/60 border border-emerald-200 rounded-xl space-y-3 animate-in fade-in">
                                <div class="text-xs space-y-1">
                                    <p class="font-bold text-emerald-950 uppercase tracking-wide">EasyPaisa Account Details:</p>
                                    <p class="text-gray-700">Title: <strong class="text-black font-mono">{{ $settings['web_easypaisa_account_title'] ?? 'ALI RAZA' }}</strong></p>
                                    <p class="text-gray-700">Account No: <strong class="text-black font-mono">{{ $settings['web_easypaisa_mobile_number'] ?? '03173340926' }}</strong></p>
                                </div>
                                <div class="space-y-2 pt-2 border-t border-emerald-200/60">
                                    <label class="font-bold text-[11px] uppercase text-gray-700 block">Transaction ID / TRX *</label>
                                    <input 
                                        type="text" 
                                        name="transaction_id" 
                                        placeholder="Enter 11-digit TRX ID" 
                                        class="w-full bg-white border border-gray-200 rounded-lg p-2.5 text-xs font-mono focus:outline-none focus:border-black"
                                    >
                                    <label class="font-bold text-[11px] uppercase text-gray-700 block pt-1">Payment Screenshot (Optional)</label>
                                    <input 
                                        type="file" 
                                        name="payment_screenshot" 
                                        accept="image/*" 
                                        class="text-xs text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-full file:border-0 file:text-[10px] file:font-bold file:uppercase file:bg-black file:text-white hover:file:bg-neutral-800"
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Order Summary (5 cols) -->
                <div class="lg:col-span-5 space-y-6">
                    <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-xs border border-gray-100 space-y-6 sticky top-24">
                        <h2 class="text-sm font-bold uppercase tracking-[0.2em] text-neutral-900 border-b border-gray-100 pb-3">
                            Order Summary (<span x-text="cartCount"></span>)
                        </h2>

                        <!-- Items List -->
                        <div class="divide-y divide-gray-100 max-h-80 overflow-y-auto scrollbar-none">
                            <template x-for="(item, idx) in cart" :key="idx">
                                <div class="py-3 flex items-center gap-3">
                                    <img 
                                        :src="item.image" 
                                        :alt="item.name" 
                                        class="w-14 h-16 object-cover rounded-lg border border-gray-100 bg-gray-50 shrink-0"
                                        x-on:error="$event.target.src = '/placeholders/outfitter_prod_1.jpg'"
                                    >
                                    <div class="flex-1 text-xs">
                                        <h4 class="font-semibold text-black uppercase leading-tight truncate" x-text="item.name"></h4>
                                        <div class="text-[10px] text-gray-400 space-x-1 pt-0.5">
                                            <span x-show="item.selectedSize" class="uppercase">Size: <span x-text="item.selectedSize"></span></span>
                                            <span x-show="item.selectedColor" class="capitalize">Color: <span x-text="item.selectedColor"></span></span>
                                        </div>
                                        <div class="text-[11px] text-gray-500 pt-1 font-mono">
                                            <span x-text="item.quantity"></span> &times; PKR <span x-text="item.price.toLocaleString()"></span>
                                        </div>
                                    </div>
                                    <div class="text-xs font-bold font-mono text-black">
                                        PKR <span x-text="(item.price * item.quantity).toLocaleString()"></span>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <!-- Calculations -->
                        <div class="border-t border-gray-100 pt-4 space-y-2 text-xs font-sans">
                            <div class="flex justify-between text-gray-600">
                                <span>Subtotal</span>
                                <span class="font-mono text-black font-semibold">PKR <span x-text="cartSubtotal.toLocaleString()"></span></span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Shipping Fee</span>
                                <template x-if="cartSubtotal >= 5000">
                                    <span class="text-emerald-700 font-bold uppercase text-[10px]">FREE</span>
                                </template>
                                <template x-if="cartSubtotal < 5000">
                                    <span class="font-mono text-black">PKR 250</span>
                                </template>
                            </div>
                            <div class="border-t border-gray-200 pt-3 flex justify-between text-base font-bold text-black">
                                <span>Total Payable</span>
                                <span class="font-mono">PKR <span x-text="(cartSubtotal + (cartSubtotal >= 5000 ? 0 : 250)).toLocaleString()"></span></span>
                            </div>
                        </div>

                        <!-- Submit Order Button -->
                        <button 
                            type="submit" 
                            class="w-full bg-black hover:bg-neutral-800 text-white font-sans text-xs font-bold uppercase tracking-[0.25em] py-4 rounded-xl shadow-lg transition-all duration-300 hover:scale-101 cursor-pointer"
                        >
                            Confirm Order
                        </button>

                        <div class="text-center space-y-1 text-[10px] text-gray-400">
                            <p class="flex items-center justify-center gap-1.5">
                                <i data-lucide="lock" class="w-3 h-3 text-emerald-700"></i> Encrypted 256-Bit SSL Checkout
                            </p>
                            <p>Delivery time: 2-4 business days nationwide</p>
                        </div>
                    </div>
                </div>
            </form>
        </template>
    </div>
</div>
@endsection
