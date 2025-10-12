<!DOCTYPE html>
<html lang="id" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard - Mini Commerce')</title>
    
    <!-- Compiled CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    @stack('styles')
</head>
<body class="h-full bg-gray-50">
    <div class="min-h-full">
        <!-- Sidebar -->
        <div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-64 lg:flex-col">
            <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-white border-r border-gray-200 px-6 pb-4 shadow-sm">
                <!-- Logo -->
                <div class="flex h-16 shrink-0 items-center">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-1">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-12 h-auto">
                        <img src="{{ asset('images/logo-text.png') }}" alt="Mini Commerce" class="h-20 w-auto -ml-8">
                    </a>
                </div>
                
                <!-- Navigation -->
                <nav class="flex flex-1 flex-col">
                    <ul role="list" class="flex flex-1 flex-col gap-y-1">
                        <li>
                            <ul role="list" class="space-y-1">
                                <!-- Dashboard -->
                                <li>
                                    @if(request()->routeIs('admin.dashboard'))
                                    <a href="{{ route('admin.dashboard') }}" class="group flex items-center gap-x-3 rounded-lg p-3 text-sm font-medium transition-colors text-gray-700" style="background-color: #FF9CBF;">
                                        <div class="w-5 h-5 flex items-center justify-center shrink-0">
                                            <i class="fas fa-chart-pie text-sm text-white"></i>
                                        </div>
                                        <span class="text-white font-semibold">Dashboard</span>
                                    </a>
                                    @else
                                    <a href="{{ route('admin.dashboard') }}" class="group flex items-center gap-x-3 rounded-lg p-3 text-sm font-medium transition-colors text-gray-700 hover:text-gray-900 hover:bg-gray-50">
                                        <div class="w-5 h-5 flex items-center justify-center shrink-0">
                                            <i class="fas fa-chart-pie text-sm text-gray-400 group-hover:text-gray-600"></i>
                                        </div>
                                        <span>Dashboard</span>
                                    </a>
                                    @endif
                                </li>
                                
                                <!-- Products -->
                                <li class="mt-6">
                                    <div class="text-xs font-semibold leading-6 text-gray-400 mb-2">PRODUK</div>
                                    <ul class="space-y-1">
                                        <li>
                                            @if(request()->routeIs('admin.products.index'))
                                            <a href="{{ route('admin.products.index') }}" class="group flex items-center gap-x-3 rounded-lg p-3 text-sm font-medium transition-colors text-gray-700" style="background-color: #FF9CBF;">
                                                <div class="w-5 h-5 flex items-center justify-center shrink-0">
                                                    <i class="fas fa-box text-sm text-white"></i>
                                                </div>
                                                <span class="text-white font-semibold">Semua Produk</span>
                                            </a>
                                            @else
                                            <a href="{{ route('admin.products.index') }}" class="group flex items-center gap-x-3 rounded-lg p-3 text-sm font-medium transition-colors text-gray-700 hover:text-gray-900 hover:bg-gray-50">
                                                <div class="w-5 h-5 flex items-center justify-center shrink-0">
                                                    <i class="fas fa-box text-sm text-gray-400 group-hover:text-gray-600"></i>
                                                </div>
                                                <span>Semua Produk</span>
                                            </a>
                                            @endif
                                        </li>
                                        <li>
                                            @if(request()->routeIs('admin.products.create'))
                                            <a href="{{ route('admin.products.create') }}" class="group flex items-center gap-x-3 rounded-lg p-3 text-sm font-medium transition-colors text-gray-700" style="background-color: #FF9CBF;">
                                                <div class="w-5 h-5 flex items-center justify-center shrink-0">
                                                    <i class="fas fa-plus text-sm text-white"></i>
                                                </div>
                                                <span class="text-white font-semibold">Tambah Produk</span>
                                            </a>
                                            @else
                                            <a href="{{ route('admin.products.create') }}" class="group flex items-center gap-x-3 rounded-lg p-3 text-sm font-medium transition-colors text-gray-700 hover:text-gray-900 hover:bg-gray-50">
                                                <div class="w-5 h-5 flex items-center justify-center shrink-0">
                                                    <i class="fas fa-plus text-sm text-gray-400 group-hover:text-gray-600"></i>
                                                </div>
                                                <span>Tambah Produk</span>
                                            </a>
                                            @endif
                                        </li>
                                        <li>
                                            @if(request()->routeIs('admin.categories.*'))
                                            <a href="{{ route('admin.categories.index') }}" class="group flex items-center gap-x-3 rounded-lg p-3 text-sm font-medium transition-colors text-gray-700" style="background-color: #FF9CBF;">
                                                <div class="w-5 h-5 flex items-center justify-center shrink-0">
                                                    <i class="fas fa-tags text-sm text-white"></i>
                                                </div>
                                                <span class="text-white font-semibold">Kategori</span>
                                            </a>
                                            @else
                                            <a href="{{ route('admin.categories.index') }}" class="group flex items-center gap-x-3 rounded-lg p-3 text-sm font-medium transition-colors text-gray-700 hover:text-gray-900 hover:bg-gray-50">
                                                <div class="w-5 h-5 flex items-center justify-center shrink-0">
                                                    <i class="fas fa-tags text-sm text-gray-400 group-hover:text-gray-600"></i>
                                                </div>
                                                <span>Kategori</span>
                                            </a>
                                            @endif
                                        </li>
                                    </ul>
                                </li>
                                
                                <!-- Orders -->
                                <li class="mt-6">
                                    <div class="text-xs font-semibold leading-6 text-gray-400 mb-2">PESANAN</div>
                                    <ul class="space-y-1">
                                        <li>
                                            @if(request()->routeIs('admin.orders.*'))
                                            <a href="{{ route('admin.orders.index') }}" class="group flex items-center gap-x-3 rounded-lg p-3 text-sm font-medium transition-colors text-gray-700" style="background-color: #FF9CBF;">
                                                <div class="w-5 h-5 flex items-center justify-center shrink-0">
                                                    <i class="fas fa-shopping-cart text-sm text-white"></i>
                                                </div>
                                                <span class="text-white font-semibold">Semua Pesanan</span>
                                            </a>
                                            @else
                                            <a href="{{ route('admin.orders.index') }}" class="group flex items-center gap-x-3 rounded-lg p-3 text-sm font-medium transition-colors text-gray-700 hover:text-gray-900 hover:bg-gray-50">
                                                <div class="w-5 h-5 flex items-center justify-center shrink-0">
                                                    <i class="fas fa-shopping-cart text-sm text-gray-400 group-hover:text-gray-600"></i>
                                                </div>
                                                <span>Semua Pesanan</span>
                                            </a>
                                            @endif
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        
                        <!-- Bottom section -->
                        <li class="mt-auto">
                            <div class="mt-4 p-3 rounded-lg" style="background-color: #FFE5EC;">
                                <div class="flex items-center">
                                    <div class="h-8 w-8 rounded-full flex items-center justify-center" style="background-color: #FF9CBF;">
                                        <span class="text-sm font-medium text-white">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                                        <form action="{{ route('logout') }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-xs hover:text-white" style="color: #B83556;">Logout</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

        <!-- Mobile sidebar -->
        <div class="lg:hidden">
            <!-- Mobile menu button -->
            <div class="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-x-4 border-b border-gray-200 bg-white px-4 shadow-sm sm:gap-x-6 sm:px-6">
                <button type="button" class="-m-2.5 p-2.5 text-gray-700 lg:hidden" id="mobile-menu-button">
                    <span class="sr-only">Open sidebar</span>
                    <i class="fas fa-bars h-6 w-6"></i>
                </button>
                
                <div class="flex flex-1 gap-x-4 self-stretch lg:gap-x-6">
                    <div class="flex items-center">
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-1">
                            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-10 h-auto">
                            <img src="{{ asset('images/logo-text.png') }}" alt="Mini Commerce" class="h-16 w-auto -ml-6">
                        </a>
                    </div>
                </div>
                
                <div class="flex items-center gap-x-4 lg:gap-x-6">
                    <div class="hidden sm:flex sm:items-center">
                        <span class="text-sm text-gray-500">{{ Auth::user()->name }}</span>
                    </div>
                </div>
            </div>
            
            <!-- Mobile sidebar overlay -->
            <div class="relative z-50 lg:hidden hidden" id="mobile-sidebar">
                <div class="fixed inset-0 bg-gray-900/80"></div>
                <div class="fixed inset-0 flex">
                    <div class="relative mr-16 flex w-full max-w-xs flex-1">
                        <div class="absolute left-full top-0 flex w-16 justify-center pt-5">
                            <button type="button" class="-m-2.5 p-2.5" id="mobile-close-button">
                                <span class="sr-only">Close sidebar</span>
                                <i class="fas fa-times h-6 w-6 text-white"></i>
                            </button>
                        </div>
                        
                        <!-- Mobile sidebar content -->
                        <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-white px-6 pb-4">
                            <div class="flex h-16 shrink-0 items-center">
                                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-1">
                                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-10 h-auto">
                                    <img src="{{ asset('images/logo-text.png') }}" alt="Mini Commerce" class="h-16 w-auto -ml-6">
                                </a>
                            </div>
                            
                            <nav class="flex flex-1 flex-col">
                                <ul role="list" class="flex flex-1 flex-col gap-y-7">
                                    <li>
                                        <ul role="list" class="-mx-2 space-y-1">
                                            <li>
                                                @if(request()->routeIs('admin.dashboard'))
                                                <a href="{{ route('admin.dashboard') }}" class="group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold text-white" style="background-color: #FF9CBF;">
                                                    <i class="fas fa-chart-pie h-6 w-6 shrink-0 text-white"></i>
                                                    Dashboard
                                                </a>
                                                @else
                                                <a href="{{ route('admin.dashboard') }}" class="group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold text-gray-700 hover:text-gray-900 hover:bg-gray-50">
                                                    <i class="fas fa-chart-pie h-6 w-6 shrink-0"></i>
                                                    Dashboard
                                                </a>
                                                @endif
                                            </li>
                                            
                                            <li>
                                                <div class="text-xs font-semibold leading-6 text-gray-400 mt-6 mb-2">PRODUK</div>
                                                <ul class="-mx-2 space-y-1">
                                                    <li>
                                                        @if(request()->routeIs('admin.products.index'))
                                                        <a href="{{ route('admin.products.index') }}" class="group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold text-white" style="background-color: #FF9CBF;">
                                                            <i class="fas fa-box h-6 w-6 shrink-0 text-white"></i>
                                                            Semua Produk
                                                        </a>
                                                        @else
                                                        <a href="{{ route('admin.products.index') }}" class="group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold text-gray-700 hover:text-gray-900 hover:bg-gray-50">
                                                            <i class="fas fa-box h-6 w-6 shrink-0"></i>
                                                            Semua Produk
                                                        </a>
                                                        @endif
                                                    </li>
                                                    <li>
                                                        @if(request()->routeIs('admin.products.create'))
                                                        <a href="{{ route('admin.products.create') }}" class="group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold text-white" style="background-color: #FF9CBF;">
                                                            <i class="fas fa-plus h-6 w-6 shrink-0 text-white"></i>
                                                            Tambah Produk
                                                        </a>
                                                        @else
                                                        <a href="{{ route('admin.products.create') }}" class="group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold text-gray-700 hover:text-gray-900 hover:bg-gray-50">
                                                            <i class="fas fa-plus h-6 w-6 shrink-0"></i>
                                                            Tambah Produk
                                                        </a>
                                                        @endif
                                                    </li>
                                                </ul>
                                            </li>
                                            
                                            <li>
                                                <div class="text-xs font-semibold leading-6 text-gray-400 mt-6 mb-2">PESANAN</div>
                                                <ul class="-mx-2 space-y-1">
                                                    <li>
                                                        @if(request()->routeIs('admin.orders.*'))
                                                        <a href="{{ route('admin.orders.index') }}" class="group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold text-white" style="background-color: #FF9CBF;">
                                                            <i class="fas fa-shopping-cart h-6 w-6 shrink-0 text-white"></i>
                                                            Semua Pesanan
                                                        </a>
                                                        @else
                                                        <a href="{{ route('admin.orders.index') }}" class="group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold text-gray-700 hover:text-gray-900 hover:bg-gray-50">
                                                            <i class="fas fa-shopping-cart h-6 w-6 shrink-0"></i>
                                                            Semua Pesanan
                                                        </a>
                                                        @endif
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <main class="lg:pl-64">
            <!-- Page header -->
            <div class="bg-white border-b border-gray-200 px-4 py-6 sm:px-6 lg:px-8">
                <div class="md:flex md:items-center md:justify-between">
                    <div class="min-w-0 flex-1">
                        <div class="flex items-center">
                            <div>
                                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                                    @yield('page-title', 'Dashboard')
                                </h2>
                                @yield('page-description')
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 flex flex-col-reverse justify-stretch space-y-4 space-y-reverse sm:flex-row-reverse sm:justify-end sm:space-x-reverse sm:space-y-0 sm:space-x-3 md:mt-0 md:flex-row md:space-x-3">
                        @yield('page-actions')
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="px-4 py-6 sm:px-6 lg:px-8">
                @yield('content')
            </div>
        </main>
    </div>

    <script>
        // Mobile menu functionality
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileCloseButton = document.getElementById('mobile-close-button');
        const mobileSidebar = document.getElementById('mobile-sidebar');

        if (mobileMenuButton) {
            mobileMenuButton.addEventListener('click', function() {
                mobileSidebar.classList.remove('hidden');
            });
        }

        if (mobileCloseButton) {
            mobileCloseButton.addEventListener('click', function() {
                mobileSidebar.classList.add('hidden');
            });
        }

        // Back button functionality
        function goBack() {
            if (window.history.length > 1) {
                window.history.back();
            } else {
                window.location.href = "{{ route('admin.dashboard') }}";
            }
        }
        
        window.goBack = goBack;
    </script>
    
    @stack('scripts')
</body>
</html>