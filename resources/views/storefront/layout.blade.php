<!DOCTYPE html>
<html lang="en" class="h-full scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', ($settings['web_site_name'] ?? 'TrendHub') . ' | Elevated Modern Luxury Menswear')</title>
    <meta name="description" content="@yield('meta_description', 'Discover modern luxury wardrobe staples designed with clean minimal aesthetics and timeless craftsmanship.')">
    <link rel="icon" href="{{ !empty($settings['web_site_logo']) ? asset($settings['web_site_logo']) : asset('favicon.ico') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">

    <!-- Tailwind CSS (CDN - Zero build step, runs instantly on any server) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        serif: ['"Playfair Display"', 'Georgia', 'serif'],
                    },
                    colors: {
                        gold: '#b89758',
                        'gold-light': '#c5a880',
                        'gold-dark': '#9b7d44',
                        primary: '#111111',
                    }
                }
            }
        }
    </script>

    <!-- Alpine.js (Reactive Storefront: Cart Drawer, Quick View Modal, Wishlist) -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- AOS (Animate On Scroll) -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        [x-cloak] { display: none !important; }
        .scrollbar-none::-webkit-scrollbar { display: none; }
        .scrollbar-none { -ms-overflow-style: none; scrollbar-width: none; }
        @keyframes infiniteScroll {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        .animate-infinite-scroll {
            display: flex;
            width: max-content;
            animation: infiniteScroll 35s linear infinite;
        }
        .animate-infinite-scroll:hover {
            animation-play-state: paused;
        }
        @keyframes pulseGlow {
            0%, 100% {
                box-shadow: 0 0 20px rgba(184, 151, 88, 0.45);
                transform: scale(1);
            }
            50% {
                box-shadow: 0 0 35px rgba(184, 151, 88, 0.8);
                transform: scale(1.02);
            }
        }
        .animate-pulse-glow {
            animation: pulseGlow 3s infinite ease-in-out;
        }
        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(200%); }
        }
        .shimmer-btn {
            position: relative;
            overflow: hidden;
        }
        .shimmer-btn::after {
            content: '';
            position: absolute;
            top: 0; left: 0;
            width: 50%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.25), transparent);
            transform: translateX(-100%);
            animation: shimmer 3.5s infinite;
        }
        @keyframes heroZoom {
            0% { transform: scale(1); }
            100% { transform: scale(1.08); }
        }
        .animate-hero-zoom {
            animation: heroZoom 25s infinite alternate ease-in-out;
        }
    </style>

    @stack('styles')
</head>
<body 
    x-data="storefrontApp()" 
    x-init="initApp()" 
    class="min-h-full flex flex-col font-sans bg-white text-[#111111] antialiased selection:bg-neutral-900 selection:text-white"
>
    <!-- Top Announcement Bar (Reference Match: 3 Columns) -->
    <div class="bg-[#0f0f0f] text-neutral-300 py-2 px-4 sm:px-8 text-[11px] font-sans border-b border-neutral-800">
        <div class="max-w-[1400px] mx-auto flex items-center justify-between">
            <!-- Left -->
            <div class="flex items-center gap-1.5 text-neutral-300">
                <span>🚚</span>
                <span class="font-medium">Free Delivery All Over Pakistan</span>
            </div>
            <!-- Center -->
            <div class="hidden sm:block text-center font-bold tracking-widest text-[#c5a880] uppercase">
                <span>FLAT 20% OFF ON NEW ARRIVALS</span>
            </div>
            <!-- Right -->
            <div class="flex items-center gap-1.5 text-neutral-300">
                <span>💵</span>
                <span class="font-medium">Cash On Delivery Available</span>
            </div>
        </div>
    </div>

    <!-- Main Navigation Header (Clean White Luxury Reference Design) -->
    <header class="sticky top-0 z-40 w-full bg-white border-b border-gray-100 shadow-xs transition-all duration-300">
        <div class="max-w-[1400px] mx-auto px-4 sm:px-8 py-3 flex items-center justify-between gap-4">
            
            <!-- Left: Monogram Logo (NB MEN'S WEAR Style) -->
            <div class="flex items-center gap-4">
                <!-- Mobile Menu Button -->
                <button
                    @click="mobileMenuOpen = true"
                    class="lg:hidden p-1.5 text-neutral-800 hover:text-black cursor-pointer"
                    aria-label="Open menu"
                >
                    <i data-lucide="menu" class="w-6 h-6"></i>
                </button>

                <a href="{{ route('storefront.home') }}" class="flex items-center gap-2 group">
                    <div class="border-2 border-neutral-900 px-2 py-0.5 font-serif font-black text-xl tracking-tighter text-neutral-900 group-hover:border-[#b89758] group-hover:text-[#b89758] transition-colors">
                        {{ strtoupper(substr($settings['web_site_name'] ?? 'NB', 0, 2)) }}
                    </div>
                    <div class="flex flex-col">
                        <span class="font-serif font-black text-base sm:text-lg tracking-[0.2em] uppercase leading-none text-neutral-900">
                            {{ $settings['web_site_name'] ?? "NB MEN'S WEAR" }}
                        </span>
                        <span class="text-[8px] sm:text-[9px] font-sans font-bold tracking-[0.35em] uppercase text-[#b89758] leading-tight">
                            MEN'S WEAR
                        </span>
                    </div>
                </a>
            </div>

            <!-- Center: Primary Nav Links -->
            <nav class="hidden lg:flex items-center gap-6 xl:gap-7 text-xs font-sans font-semibold tracking-wide">
                <a 
                    href="{{ route('storefront.home') }}" 
                    class="transition-colors pb-0.5 {{ request()->routeIs('storefront.home') ? 'text-[#b89758] font-bold border-b-2 border-[#b89758]' : 'text-neutral-800 hover:text-[#b89758]' }}"
                >
                    Home
                </a>
                <a 
                    href="{{ route('storefront.shop', ['category' => 'TROUSERS']) }}" 
                    class="text-neutral-800 hover:text-[#b89758] transition-colors pb-0.5"
                >
                    Trousers
                </a>
                <a 
                    href="{{ route('storefront.shop', ['category' => 'SHIRTS']) }}" 
                    class="text-neutral-800 hover:text-[#b89758] transition-colors pb-0.5"
                >
                    Shirts
                </a>
                <a 
                    href="{{ route('storefront.shop', ['category' => 'T-SHIRTS']) }}" 
                    class="text-neutral-800 hover:text-[#b89758] transition-colors pb-0.5"
                >
                    T-Shirts
                </a>
                <a 
                    href="{{ route('storefront.shop', ['category' => 'JEANS']) }}" 
                    class="text-neutral-800 hover:text-[#b89758] transition-colors pb-0.5"
                >
                    Jeans
                </a>
                <a 
                    href="{{ route('storefront.shop', ['tag' => 'New Arrival']) }}" 
                    class="text-neutral-800 hover:text-[#b89758] transition-colors pb-0.5"
                >
                    New Arrivals
                </a>
                <a 
                    href="{{ route('storefront.shop', ['tag' => 'Best Seller']) }}" 
                    class="text-neutral-800 hover:text-[#b89758] transition-colors pb-0.5"
                >
                    Best Sellers
                </a>
                <a 
                    href="{{ route('storefront.shop', ['tag' => 'Sale']) }}" 
                    class="text-red-600 hover:text-red-700 font-bold transition-colors pb-0.5"
                >
                    Sale
                </a>
            </nav>

            <!-- Right: Search Bar, Profile, Wishlist, Cart -->
            <div class="flex items-center gap-3 sm:gap-4">
                <!-- Search Input Pill (with Gold Search Button) -->
                <form action="{{ route('storefront.shop') }}" method="GET" class="hidden md:flex items-center">
                    <div class="relative flex items-center">
                        <input 
                            type="text" 
                            name="search" 
                            placeholder="Search for products..." 
                            class="bg-gray-50 border border-gray-200 text-xs px-3.5 py-1.5 rounded-l-md w-44 lg:w-56 focus:outline-none focus:border-[#b89758] transition-colors text-black placeholder-gray-400"
                        >
                        <button type="submit" class="bg-[#b89758] hover:bg-[#a6864a] text-white px-3 py-1.5 rounded-r-md transition-colors flex items-center justify-center cursor-pointer" aria-label="Search">
                            <i data-lucide="search" class="w-3.5 h-3.5"></i>
                        </button>
                    </div>
                </form>

                <!-- Mobile Search Trigger -->
                <button
                    @click="searchModalOpen = true"
                    class="md:hidden p-1.5 text-neutral-800 hover:text-[#b89758] cursor-pointer"
                    aria-label="Search"
                >
                    <i data-lucide="search" class="w-5 h-5"></i>
                </button>

                <!-- User Profile / ERP Login -->
                <a 
                    href="{{ url('/software') }}" 
                    class="p-1.5 text-neutral-800 hover:text-[#b89758] transition-colors cursor-pointer" 
                    title="My Account / Login"
                >
                    <i data-lucide="user" class="w-5 h-5"></i>
                </a>

                <!-- Wishlist with Counter Badge -->
                <a 
                    href="{{ route('storefront.wishlist') }}" 
                    class="p-1.5 text-neutral-800 hover:text-[#b89758] transition-colors relative cursor-pointer" 
                    title="Wishlist"
                >
                    <i data-lucide="heart" class="w-5 h-5"></i>
                    <span 
                        x-text="wishlist.length" 
                        class="absolute -top-1 -right-1 bg-[#b89758] text-white text-[9px] font-bold w-4 h-4 rounded-full flex items-center justify-center font-mono shadow-xs"
                    >0</span>
                </a>

                <!-- Shopping Bag with Counter Badge -->
                <button 
                    @click="isCartOpen = true" 
                    class="p-1.5 text-neutral-800 hover:text-[#b89758] transition-colors relative cursor-pointer" 
                    title="Cart"
                >
                    <i data-lucide="shopping-bag" class="w-5 h-5"></i>
                    <span 
                        x-text="cartCount" 
                        class="absolute -top-1 -right-1 bg-[#b89758] text-white text-[9px] font-bold w-4 h-4 rounded-full flex items-center justify-center font-mono shadow-xs"
                    >0</span>
                </button>
            </div>
        </div>

        <!-- Mobile Drawer Navigation -->
        <div 
            x-show="mobileMenuOpen" 
            x-cloak
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="-translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
            class="fixed inset-0 z-50 lg:hidden flex"
        >
            <div class="fixed inset-0 bg-black/60 backdrop-blur-xs" @click="mobileMenuOpen = false"></div>
            <div class="relative bg-white w-4/5 max-w-sm h-full p-6 flex flex-col justify-between shadow-2xl z-10 overflow-y-auto">
                <div class="space-y-6">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                        <span class="font-serif font-bold text-lg uppercase tracking-widest text-black">
                            {{ $settings['web_site_name'] ?? 'TREND HUB' }}
                        </span>
                        <button @click="mobileMenuOpen = false" class="p-1.5 text-gray-400 hover:text-black">
                            <i data-lucide="x" class="w-5 h-5"></i>
                        </button>
                    </div>

                    <nav class="flex flex-col space-y-4 text-xs font-semibold uppercase tracking-[0.2em] text-neutral-800">
                        <a href="{{ route('storefront.home') }}" class="py-2 border-b border-gray-50 hover:text-black">Home</a>
                        <a href="{{ route('storefront.shop') }}" class="py-2 border-b border-gray-50 hover:text-black">All Collections</a>
                        <a href="{{ route('storefront.shop', ['tag' => 'New Arrival']) }}" class="py-2 border-b border-gray-50 hover:text-black">New Arrivals</a>
                        <a href="{{ route('storefront.shop', ['tag' => 'Best Seller']) }}" class="py-2 border-b border-gray-50 hover:text-black">Best Sellers</a>
                        <a href="{{ route('storefront.store_locator') }}" class="py-2 border-b border-gray-50 hover:text-black">Store Locator</a>
                        <a href="{{ route('storefront.wishlist') }}" class="py-2 border-b border-gray-50 hover:text-black">Wishlist (<span x-text="wishlist.length"></span>)</a>
                    </nav>
                </div>

                <div class="border-t border-gray-100 pt-6 space-y-3 text-[11px] text-gray-500">
                    <p class="font-medium text-black">Customer Support</p>
                    <p>WhatsApp: +92 {{ ltrim($settings['web_whatsapp_number'] ?? '3173340926', '0') }}</p>
                    <p>Email: {{ $settings['web_contact_email'] ?? 'trendhubstorepk1@gmail.com' }}</p>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('storefront.partials.footer')

    <!-- Side Cart Drawer -->
    @include('storefront.partials.cart-drawer')

    <!-- Quick View Modal -->
    @include('storefront.partials.quick-view')

    <!-- Search Modal -->
    <div 
        x-show="searchModalOpen" 
        x-cloak 
        class="fixed inset-0 z-50 flex items-start justify-center pt-24 bg-black/70 backdrop-blur-xs p-4"
        @keydown.escape.window="searchModalOpen = false"
    >
        <div class="bg-white w-full max-w-xl rounded-xl shadow-2xl p-6 relative animate-in fade-in zoom-in-95" @click.outside="searchModalOpen = false">
            <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                <span class="text-xs uppercase tracking-widest font-bold text-gray-400">Search Products</span>
                <button @click="searchModalOpen = false" class="text-gray-400 hover:text-black"><i data-lucide="x" class="w-5 h-5"></i></button>
            </div>
            <form action="{{ route('storefront.shop') }}" method="GET" class="pt-4 flex gap-2">
                <input 
                    type="text" 
                    name="q" 
                    placeholder="Search shirts, trousers, polos, jackets..." 
                    class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-black font-sans"
                    autofocus
                >
                <button type="submit" class="bg-black hover:bg-neutral-800 text-white px-5 py-2.5 rounded-lg text-xs uppercase font-bold tracking-wider">
                    Search
                </button>
            </form>
        </div>
    </div>

    <!-- Floating WhatsApp Button -->
    @php
        $rawWa = $settings['web_whatsapp_number'] ?? '3173340926';
        $cleanWa = preg_replace('/[^0-9]/', '', $rawWa);
        if (str_starts_with($cleanWa, '0')) {
            $cleanWa = '92' . substr($cleanWa, 1);
        } elseif (!str_starts_with($cleanWa, '92')) {
            $cleanWa = '92' . $cleanWa;
        }
    @endphp
    <a 
        href="https://wa.me/{{ $cleanWa }}?text={{ urlencode('Assalam-o-Alaikum TrendHub, I am interested in your menswear collection.') }}" 
        target="_blank"
        rel="noopener noreferrer"
        class="fixed bottom-6 right-6 z-40 bg-[#25D366] hover:bg-[#20ba5a] text-white p-3.5 rounded-full shadow-2xl transition-all duration-300 hover:scale-110 flex items-center justify-center group"
        aria-label="Contact us on WhatsApp"
    >
        <i data-lucide="message-circle" class="w-6 h-6 fill-white stroke-none"></i>
        <span class="max-w-0 overflow-hidden whitespace-nowrap group-hover:max-w-xs transition-all duration-500 text-xs font-bold font-sans pl-0 group-hover:pl-2">
            Chat with us
        </span>
    </a>

    <!-- Global Storefront Alpine App State -->
    <script>
        function storefrontApp() {
            return {
                mobileMenuOpen: false,
                searchModalOpen: false,
                isCartOpen: false,
                cart: [],
                wishlist: [],
                quickView: {
                    isOpen: false,
                    product: null,
                    activeImg: '',
                    selectedSize: '',
                    selectedColor: '',
                    qty: 1
                },

                initApp() {
                    // Load Cart from localStorage
                    try {
                        const savedCart = localStorage.getItem('th_cart');
                        if (savedCart) this.cart = JSON.parse(savedCart);
                    } catch (e) {
                        this.cart = [];
                    }

                    // Load Wishlist from localStorage
                    try {
                        const savedWish = localStorage.getItem('th_wishlist');
                        if (savedWish) this.wishlist = JSON.parse(savedWish);
                    } catch (e) {
                        this.wishlist = [];
                    }

                    // Re-render icons and AOS animations on mount
                    this.$nextTick(() => {
                        if (window.lucide) window.lucide.createIcons();
                        if (window.AOS) {
                            window.AOS.init({
                                once: true,
                                duration: 700,
                                easing: 'ease-out-cubic',
                                offset: 40
                            });
                        }
                    });
                },

                saveCart() {
                    localStorage.setItem('th_cart', JSON.stringify(this.cart));
                },

                get cartCount() {
                    return this.cart.reduce((sum, item) => sum + (parseInt(item.quantity) || 1), 0);
                },

                get cartSubtotal() {
                    return this.cart.reduce((sum, item) => sum + ((parseFloat(item.price) || 0) * (parseInt(item.quantity) || 1)), 0);
                },

                addToCart(product, quantity = 1, size = null, color = null) {
                    const price = parseFloat(product.final_price || product.web_sale_price || product.sale_price_per_piece || 0);
                    const image = product.display_image || product.image || '/placeholders/outfitter_prod_1.jpg';
                    const name = product.item_name || 'Apparel Item';
                    const id = product.id;

                    const existingIndex = this.cart.findIndex(i => 
                        i.id === id && i.selectedSize === size && i.selectedColor === color
                    );

                    if (existingIndex > -1) {
                        this.cart[existingIndex].quantity += parseInt(quantity) || 1;
                    } else {
                        this.cart.push({
                            id: id,
                            name: name,
                            price: price,
                            image: image,
                            quantity: parseInt(quantity) || 1,
                            selectedSize: size || '',
                            selectedColor: color || ''
                        });
                    }

                    this.saveCart();
                    this.isCartOpen = true;
                    this.$nextTick(() => {
                        if (window.lucide) window.lucide.createIcons();
                    });
                },

                updateCartQty(index, newQty) {
                    if (newQty <= 0) {
                        this.removeFromCart(index);
                    } else {
                        this.cart[index].quantity = newQty;
                        this.saveCart();
                    }
                },

                removeFromCart(index) {
                    this.cart.splice(index, 1);
                    this.saveCart();
                },

                toggleWishlist(productId) {
                    const id = parseInt(productId);
                    const idx = this.wishlist.indexOf(id);
                    if (idx > -1) {
                        this.wishlist.splice(idx, 1);
                    } else {
                        this.wishlist.push(id);
                    }
                    localStorage.setItem('th_wishlist', JSON.stringify(this.wishlist));
                },

                isInWishlist(productId) {
                    return this.wishlist.includes(parseInt(productId));
                },

                openQuickView(productData) {
                    this.quickView.product = productData;
                    this.quickView.activeImg = productData.display_image || (productData.gallery_images && productData.gallery_images[0]) || '';
                    this.quickView.selectedSize = (productData.parsed_sizes && productData.parsed_sizes[0]) || '';
                    this.quickView.selectedColor = (productData.parsed_colors && productData.parsed_colors[0]) || '';
                    this.quickView.qty = 1;
                    this.quickView.isOpen = true;

                    this.$nextTick(() => {
                        if (window.lucide) window.lucide.createIcons();
                    });
                },

                closeQuickView() {
                    this.quickView.isOpen = false;
                }
            }
        }
    </script>

    @stack('scripts')
</body>
</html>
