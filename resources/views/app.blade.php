<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Mini Commerce')</title>
    
    <!-- Compiled CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    @stack('styles')
</head>
<body style="background-color: #F9CDD5;">
    <!-- Navigation -->
    <nav style="background-color: #F9CDD5;" class="shadow-lg sticky top-0 z-50">
        <div class="w-full px-2">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center pl-2">
                    <a href="{{ url('/') }}" class="flex items-center space-x-1">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-12 h-auto ml-4">
                       <img src="{{ asset('images/logo-text.png') }}" alt="Mini Commerce" class="h-20 w-auto -ml-8">
                    </a>
                </div>

                <!-- Right Menu -->
                <div class="flex items-center space-x-4">
                    @auth
                        <!-- Cart -->
                        <a href="{{ route('cart.index') }}" class="relative p-2 text-gray-600 hover:text-primary-600 transition-colors">
                            <i class="fas fa-shopping-cart text-xl"></i>
                            <span id="cart-count" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">0</span>
                        </a>

                        <!-- User Menu -->
                        <div class="relative group">
                            <button class="flex items-center space-x-2 text-gray-700 hover:text-primary-600 transition-colors">
                                <i class="fas fa-user"></i>
                                <span class="hidden sm:block">{{ Auth::user()->name }}</span>
                                <i class="fas fa-chevron-down text-sm"></i>
                            </button>
                            
                            <div class="absolute right-0 mt-2 w-48 rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50" style="background-color: #F9CDD5;">
                                <div class="py-1">
                                    @if(Auth::user()->isAdmin())
                                        <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <i class="fas fa-tachometer-alt mr-2"></i>Admin Dashboard
                                        </a>
                                    @endif
                                    <a href="{{ route('orders.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-box mr-2"></i>Pesanan Saya
                                    </a>
                                    <hr class="my-1">
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-primary-600 transition-colors">
                            <i class="fas fa-sign-in-alt mr-1"></i>Login
                        </a>
                        <a href="{{ route('auth.register') }}" class="bg-[#B83556] text-white px-4 py-2 rounded-lg hover:bg-[#FF9CBF] transition-colors">
                            Daftar
                        </a>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button id="mobile-menu-btn" class="text-gray-600 hover:text-primary-600">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div id="mobile-menu" class="hidden md:hidden border-t" style="background-color: #F9CDD5;">
            <div class="px-4 pt-2 pb-3 space-y-1">
                @auth
                    <a href="{{ route('cart.index') }}" class="block px-3 py-2 text-gray-700 hover:bg-gray-100 rounded-md">
                        <i class="fas fa-shopping-cart mr-2"></i>Keranjang
                    </a>
                    <a href="{{ route('orders.index') }}" class="block px-3 py-2 text-gray-700 hover:bg-gray-100 rounded-md">
                        <i class="fas fa-box mr-2"></i>Pesanan Saya
                    </a>
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 text-gray-700 hover:bg-gray-100 rounded-md">
                            <i class="fas fa-tachometer-alt mr-2"></i>Admin Dashboard
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="block px-3 py-2 text-gray-700 hover:bg-gray-100 rounded-md">
                        <i class="fas fa-sign-in-alt mr-2"></i>Login
                    </a>
                    <a href="{{ route('auth.register') }}" class="block px-3 py-2 text-gray-700 hover:bg-gray-100 rounded-md">
                        <i class="fas fa-user-plus mr-2"></i>Daftar
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if(session('success'))
        <div id="flash-message" class="bg-secondary-100 border border-secondary-400 text-secondary-700 px-4 py-3 rounded relative mx-4 mt-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer" onclick="this.parentElement.style.display='none';">
                <i class="fas fa-times"></i>
            </span>
        </div>
    @endif

    @if(session('error'))
        <div id="flash-message" class="bg-danger-100 border border-danger-400 text-danger-700 px-4 py-3 rounded relative mx-4 mt-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer" onclick="this.parentElement.style.display='none';">
                <i class="fas fa-times"></i>
            </span>
        </div>
    @endif

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Company Info -->
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center space-x-1 mb-4">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-12 h-auto ml-2">
                        <img src="{{ asset('images/logo-text.png') }}" alt="Mini Commerce" class="h-20 w-auto -ml-8">
                    </div>
                    <p class="text-gray-300 mb-4">
                        Platform e-commerce yang mendukung produk UMKM lokal Indonesia. 
                        Temukan berbagai produk berkualitas dari usaha kecil menengah terpercaya.
                    </p>
                </div>

                <!-- Contact Info -->
                <div class="ml-0 md:ml-8">
                    <h3 class="text-lg font-semibold mb-4">Kontak</h3>
                    <ul class="space-y-2 text-gray-300">
                        <li><i class="fas fa-envelope mr-2"></i>info@umkmcommerce.com</li>
                        <li><i class="fas fa-phone mr-2"></i>+62 123 456 7890</li>
                        <li><i class="fas fa-map-marker-alt mr-2"></i>Jakarta, Indonesia</li>
                    </ul>
                </div>
            </div>

            <hr class="border-gray-800 my-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400 text-sm">
                    © {{ date('Y') }} UMKM Commerce. All rights reserved.
                </p>
                <div class="flex space-x-4 mt-4 md:mt-0">
                    <a href="#" class="text-gray-400 hover:text-primary-400 transition-colors">
                        <i class="fab fa-facebook"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-primary-400 transition-colors">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-primary-400 transition-colors">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-btn').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });

        // Auto-hide flash messages
        setTimeout(function() {
            const flashMessage = document.getElementById('flash-message');
            if (flashMessage) {
                flashMessage.style.display = 'none';
            }
        }, 5000);
    </script>
    
    @auth
    <script>
        // Update cart count
        function updateCartCount() {
            fetch('/api/cart/count')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('cart-count').textContent = data.count;
                });
        }
        
        // Update cart count on page load
        updateCartCount();
    </script>
    @endauth
    
    @stack('scripts')
</body>
</html>