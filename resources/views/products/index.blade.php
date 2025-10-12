@extends('app')

<<<<<<< HEAD
@section('title', 'Produk - Mini Commerce')

@section('content')
<div class="min-h-screen" style="background-color: #F9CDD5;">
    <!-- Header Section -->
    <div class="shadow-sm border-b" style="background: linear-gradient(to right, #B83556, #FF9CBF);">
        <div class="w-full px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div class="flex-shrink-0">
                    <h1 class="text-3xl font-bold text-white">
                        @if(isset($category))
                            Produk Kategori: {{ $category->name }}
                        @elseif(isset($searchTerm) && $searchTerm)
                            Hasil Pencarian: "{{ $searchTerm }}"
                        @else
                            Semua Produk
                        @endif
                    </h1>
                    <p class="mt-2 text-white">Temukan produk berkualitas dari UMKM terpercaya</p>
                </div>
                
                <!-- Search Form in Header -->
                <div class="flex-grow">
                    <form action="{{ route('products.search') }}" method="GET" class="flex gap-2">
                        @if(isset($category))
                            <input type="hidden" name="category" value="{{ $category->id }}">
                        @endif
                        @if(request('min_price'))
                            <input type="hidden" name="min_price" value="{{ request('min_price') }}">
                        @endif
                        @if(request('max_price'))
                            <input type="hidden" name="max_price" value="{{ request('max_price') }}">
                        @endif
                        @if(request('sort'))
                            <input type="hidden" name="sort" value="{{ request('sort') }}">
                        @endif
                        
                        <div class="relative flex-grow">
                            <input type="text" 
                                   id="search-header" 
                                   name="search" 
                                   value="{{ request('search') }}"
                                   placeholder="Ketik untuk mencari produk..."
                                   class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                            <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            @if(request('search'))
                                <button type="button" 
                                        onclick="document.getElementById('search-header').value=''; this.closest('form').submit();"
                                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                    <i class="fas fa-times"></i>
                                </button>
                            @endif
                        </div>
                    </form>
                </div>
                
                <div class="flex-shrink-0 text-right">
                    <span class="text-sm text-white">{{ $products->total() }} produk ditemukan</span>
                </div>
            </div>
        </div>
    </div>

    <div class="w-full px-4 sm:px-6 lg:px-8 py-8">
        <div class="lg:grid lg:grid-cols-4 lg:gap-8">
            <!-- Sidebar Filters -->
            <div class="lg:col-span-1 order-last lg:order-first">
                <div class="rounded-lg shadow-sm p-6 mb-6 lg:mb-0" style="background-color: #FF9CBF;">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Filter</h3>
                    
                    <!-- Filter Form -->
                    <form action="{{ route('products.search') }}" method="GET" class="space-y-4">
                        <!-- Preserve category filter if exists -->
                        @if(isset($category))
                            <input type="hidden" name="category" value="{{ $category->id }}">
                        @endif
                        
                        <!-- Preserve search term if exists -->
                        @if(request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif

                        <!-- Category Filter -->
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-tags mr-1"></i>Kategori
                            </label>
                            <select id="category" 
                                    name="category" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" 
                                            {{ (request('category') == $cat->id || (isset($category) && $category->id == $cat->id)) ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Price Range -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-money-bill-wave mr-1"></i>Rentang Harga
                            </label>
                            <div class="grid grid-cols-2 gap-2">
                                <input type="number" 
                                       name="min_price" 
                                       placeholder="Min"
                                       value="{{ request('min_price') }}"
                                       class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                                <input type="number" 
                                       name="max_price" 
                                       placeholder="Max"
                                       value="{{ request('max_price') }}"
                                       class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                            </div>
                        </div>

                        <!-- Sort Options -->
                        <div>
                            <label for="sort" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-sort mr-1"></i>Urutkan
                            </label>
                            <select id="sort" 
                                    name="sort" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Terbaru</option>
                                <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nama A-Z</option>
                                <option value="price" {{ request('sort') == 'price' ? 'selected' : '' }}>Harga</option>
                            </select>
                        </div>

                        <div class="flex space-x-2">
                            <button type="submit" 
                                    class="flex-1 text-white px-4 py-2 rounded-md transition-colors font-medium"
                                    style="background-color: #B83556;"
                                    onmouseover="this.style.backgroundColor='#952B47'"
                                    onmouseout="this.style.backgroundColor='#B83556'">
                                <i class="fas fa-filter mr-1"></i>Filter
                            </button>
                            <a href="{{ route('products.index') }}" 
                               class="flex-1 bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 transition-colors text-center font-medium">
                                Reset
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Category Quick Links -->
                <div class="rounded-lg shadow-sm p-6" style="background-color: #FF9CBF;">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Kategori Populer</h3>
                    <div class="space-y-2">
                        @foreach($categories->take(8) as $cat)
                            <a href="{{ route('products.category', $cat->slug) }}" 
                               class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md transition-colors {{ (isset($category) && $category->id == $cat->id) ? 'bg-primary-50 text-primary-700' : '' }}">
                                <i class="fas fa-tag mr-2 text-xs"></i>{{ $cat->name }}
                                <span class="text-xs text-gray-500">({{ $cat->products_count ?? $cat->activeProducts->count() }})</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="lg:col-span-3">
                @if($products->count() > 0)
                    <!-- Products Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach($products as $product)
                            <div class="rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200 overflow-hidden group" style="background-color: #FF9CBF;">
                                <!-- Product Image -->
                                <div class="aspect-w-1 aspect-h-1 bg-gray-200 overflow-hidden">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" 
                                             alt="{{ $product->name }}"
                                             class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-200">
                                    @else
                                        <div class="w-full h-48 flex items-center justify-center bg-gray-100">
                                            <i class="fas fa-image text-gray-400 text-4xl"></i>
                                        </div>
                                    @endif
                                </div>

                                <!-- Product Info -->
                                <div class="p-4">
                                    <!-- Category Badge -->
                                    <div class="mb-2">
                                        <span class="inline-block text-white text-xs px-2 py-1 rounded-full" style="background-color: #B83556;">
                                            {{ $product->category->name }}
                                        </span>
                                    </div>

                                    <!-- Product Name -->
                                    <h3 class="text-lg font-semibold text-white mb-2 group-hover:text-gray-900 transition-colors">
                                        <a href="{{ route('products.show', $product->slug) }}">
                                            {{ $product->name }}
                                        </a>
                                    </h3>

                                    <!-- Product Description -->
                                    <p class="text-gray-600 text-sm mb-3 line-clamp-2">
                                        {{ Str::limit($product->description, 80) }}
                                    </p>

                                    <!-- Price and Stock -->
                                    <div class="flex items-center justify-between mb-4">
                                        <div>
                                            <span class="text-xl font-bold text-gray-900">{{ $product->formatted_price }}</span>
                                        </div>
                                        <div class="text-right">
                                            @if($product->stock > 0)
                                                <span class="text-sm text-green-600">
                                                    <i class="fas fa-check-circle mr-1"></i>Stok: {{ $product->stock }}
                                                </span>
                                            @else
                                                <span class="text-sm text-red-600">
                                                    <i class="fas fa-times-circle mr-1"></i>Stok Habis
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="flex space-x-2">
                                        <a href="{{ route('products.show', $product->slug) }}" 
                                           class="flex-1 bg-gray-100 text-gray-700 px-3 py-2 rounded-md hover:bg-gray-200 transition-colors text-center text-sm font-medium">
                                            <i class="fas fa-eye mr-1"></i>Detail
                                        </a>
                                        
                                        @auth
                                            @if($product->stock > 0)
                                                <button data-product-id="{{ $product->id }}" 
                                                        class="flex-1 text-white px-3 py-2 rounded-md transition-colors text-sm font-medium add-to-cart-btn"
                                                        style="background-color: #B83556;"
                                                        onmouseover="this.style.backgroundColor='#952B47'"
                                                        onmouseout="this.style.backgroundColor='#B83556'"
                                                        onmousedown="this.style.color='white'"
                                                        onmouseup="this.style.color='white'">
                                                    <i class="fas fa-cart-plus mr-1"></i>Keranjang
                                                </button>
                                            @else
                                                <button disabled 
                                                        class="flex-1 bg-gray-300 text-gray-500 px-3 py-2 rounded-md cursor-not-allowed text-sm font-medium">
                                                    <i class="fas fa-times mr-1"></i>Habis
                                                </button>
                                            @endif
                                        @else
                                            <a href="{{ route('login') }}" 
                                               class="flex-1 text-white px-3 py-2 rounded-md transition-colors text-center text-sm font-medium"
                                               style="background-color: #B83556;"
                                               onmouseover="this.style.backgroundColor='#952B47'"
                                               onmouseout="this.style.backgroundColor='#B83556'"
                                               onmousedown="this.style.color='white'"
                                               onmouseup="this.style.color='white'">
                                                <i class="fas fa-sign-in-alt mr-1"></i>Login
                                            </a>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8">
                        {{ $products->appends(request()->query())->links() }}
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="rounded-lg shadow-sm p-12 text-center" style="background-color: #FF9CBF;">
                        <i class="fas fa-search text-white text-6xl mb-4"></i>
                        <h3 class="text-xl font-semibold text-white mb-2">Produk Tidak Ditemukan</h3>
                        <p class="text-white mb-6">
                            @if(isset($searchTerm) && $searchTerm)
                                Maaf, tidak ada produk yang sesuai dengan pencarian "{{ $searchTerm }}".
                            @elseif(isset($category))
                                Belum ada produk dalam kategori "{{ $category->name }}".
                            @else
                                Belum ada produk yang tersedia saat ini.
                            @endif
                        </p>
                        <div class="space-x-4">
                            <a href="{{ route('products.index') }}" 
                               class="inline-block text-white px-6 py-2 rounded-md transition-colors font-medium"
                               style="background-color: #B83556;"
                               onmouseover="this.style.backgroundColor='#952B47'"
                               onmouseout="this.style.backgroundColor='#B83556'">
                                Lihat Semua Produk
                            </a>
                            @if(isset($searchTerm) || isset($category))
                                <a href="{{ route('products.index') }}" 
                                   class="inline-block bg-white text-gray-700 px-6 py-2 rounded-md hover:bg-gray-100 transition-colors font-medium">
                                    Reset Filter
                                </a>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Loading Modal -->
<div id="loading-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-1/2 mx-auto p-5 border w-80 shadow-lg rounded-md bg-white transform -translate-y-1/2">
        <div class="text-center">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto mb-4"></div>
            <h3 class="text-lg font-medium text-gray-900">Menambahkan ke keranjang...</h3>
=======
@section('title', 'Daftar Produk - Mini Commerce')

@section('content')
<div class="min-h-screen py-8 relative overflow-hidden" style="background-color: #F9CDD5;">
    <!-- Sakura Decorations -->
    <div class="absolute inset-0 pointer-events-none">
        <img src="https://raw.githubusercontent.com/twitter/twemoji/master/assets/svg/1f338.svg" 
             alt="sakura" 
             class="absolute top-10 left-10 w-14 h-14 opacity-20 animate-pulse">
        <img src="https://raw.githubusercontent.com/twitter/twemoji/master/assets/svg/1f338.svg" 
             alt="sakura" 
             class="absolute top-32 left-32 w-12 h-12 opacity-15 animate-pulse" 
             style="animation-delay: 0.5s;">
        <img src="https://raw.githubusercontent.com/twitter/twemoji/master/assets/svg/1f338.svg" 
             alt="sakura" 
             class="absolute top-20 right-20 w-14 h-14 opacity-20 animate-pulse" 
             style="animation-delay: 1s;">
        <img src="https://raw.githubusercontent.com/twitter/twemoji/master/assets/svg/1f338.svg" 
             alt="sakura" 
             class="absolute bottom-20 left-20 w-12 h-12 opacity-15 animate-pulse" 
             style="animation-delay: 0.8s;">
        <img src="https://raw.githubusercontent.com/twitter/twemoji/master/assets/svg/1f338.svg" 
             alt="sakura" 
             class="absolute bottom-32 right-32 w-14 h-14 opacity-20 animate-pulse" 
             style="animation-delay: 1.2s;">
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Header -->
        <div class="mb-8 pt-8">
            <h1 class="text-3xl font-bold text-gray-900">Daftar Produk</h1>
            <p class="text-gray-600 mt-2">Temukan produk UMKM berkualitas</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Products Section (Left 2 columns) -->
            <div class="lg:col-span-2">
                <!-- Filter & Search -->
                <div class="bg-white rounded-xl shadow-md p-4 mb-6">
                    <form action="{{ route('products.search') }}" method="GET" class="flex gap-4">
                        <input type="text" 
                               name="search" 
                               placeholder="Cari produk..." 
                               value="{{ $searchTerm ?? '' }}"
                               class="flex-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2"
                               style="focus:ring-color: #B83556;">
                        <button type="submit" 
                                class="px-6 py-2 text-white rounded-lg font-semibold transition-colors"
                                style="background-color: #B83556;">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>

                <!-- Products Grid -->
                @if($products->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    @foreach($products as $product)
                    <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 group">
                        <div class="relative overflow-hidden rounded-t-xl">
                            <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/400x300?text=No+Image' }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                            
                            @if($product->stock <= 10 && $product->stock > 0)
                                <div class="absolute top-2 left-2 text-white px-2 py-1 rounded-full text-xs font-semibold" style="background-color: #F9C74F;">
                                    Stok Terbatas
                                </div>
                            @elseif($product->stock == 0)
                                <div class="absolute top-2 left-2 bg-danger-500 text-white px-2 py-1 rounded-full text-xs font-semibold">
                                    Habis
                                </div>
                            @endif
                        </div>

                        <div class="p-6">
                            <div class="mb-2">
                                <span class="text-xs text-white font-semibold px-2 py-1 rounded-full" style="background-color: #B83556;">
                                    {{ $product->category->name }}
                                </span>
                            </div>
                            
                            <h3 class="font-semibold text-gray-900 mb-2">
                                <a href="{{ route('products.show', $product->slug) }}">
                                    {{ $product->name }}
                                </a>
                            </h3>
                            
                            <p class="text-gray-600 text-sm mb-3 line-clamp-2">
                                {{ Str::limit($product->description, 80) }}
                            </p>
                            
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-lg font-bold" style="color: #B83556;">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </span>
                                <span class="text-sm text-gray-500">
                                    Stok: {{ $product->stock }}
                                </span>
                            </div>

                            <div class="flex gap-2">
                                <a href="{{ route('products.show', $product->slug) }}" 
                                   class="flex-1 bg-gray-100 text-gray-700 px-4 py-2 rounded-lg text-center hover:bg-gray-200 transition-colors">
                                    Lihat Detail
                                </a>
                                
                                @auth
                                    @if($product->stock > 0)
                                        <button data-product-id="{{ $product->id }}" 
                                                class="add-to-cart-btn text-white px-4 py-2 rounded-lg transition-colors" 
                                                style="background-color: #B83556;">
                                            <i class="fas fa-cart-plus"></i>
                                        </button>
                                    @else
                                        <button disabled 
                                                class="bg-gray-300 text-gray-500 px-4 py-2 rounded-lg cursor-not-allowed">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" 
                                       class="text-white px-4 py-2 rounded-lg transition-colors" 
                                       style="background-color: #B83556;">
                                        <i class="fas fa-cart-plus"></i>
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $products->links() }}
                </div>
                @else
                <div class="bg-white rounded-xl shadow-md p-12 text-center">
                    <i class="fas fa-box-open text-gray-300 text-6xl mb-4"></i>
                    <p class="text-gray-600">Produk tidak ditemukan</p>
                </div>
                @endif
            </div>

            <!-- Cart Section (Right 1 column) -->
            @auth
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-md sticky top-24" id="cart-sidebar">
                    <!-- Cart Header -->
                    <div class="p-4 border-b" style="background-color: #FF9CBF;">
                        <h2 class="text-xl font-bold text-white flex items-center justify-between">
                            <span><i class="fas fa-shopping-cart mr-2"></i>Keranjang</span>
                            <span class="text-sm" id="cart-item-count">{{ $cartData ? count($cartData['items']) : 0 }} Item</span>
                        </h2>
                    </div>

                    <!-- Cart Items -->
                    <div id="cart-items-list" class="max-h-96 overflow-y-auto">
                        @if($cartData && count($cartData['items']) > 0)
                            @foreach($cartData['items'] as $item)
                            <div class="p-4 border-b hover:bg-gray-50 cart-item-mini" data-product-id="{{ $item->product->id }}">
                                <div class="flex items-start space-x-3">
                                    <img src="{{ $item->product->image ? asset('storage/' . $item->product->image) : 'https://via.placeholder.com/60' }}" 
                                         alt="{{ $item->product->name }}"
                                         class="w-16 h-16 object-cover rounded-lg">
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-sm font-semibold text-gray-900 truncate">{{ $item->product->name }}</h4>
                                        <p class="text-sm font-bold mt-1" style="color: #B83556;">
                                            Rp {{ number_format($item->product->price, 0, ',', '.') }}
                                        </p>
                                        <div class="flex items-center mt-2">
                                            <button class="qty-decrease-mini px-2 py-1 bg-gray-100 rounded text-xs" data-product-id="{{ $item->product->id }}">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <span class="qty-display mx-2 text-sm font-semibold">{{ $item->qty }}</span>
                                            <button class="qty-increase-mini px-2 py-1 bg-gray-100 rounded text-xs" data-product-id="{{ $item->product->id }}">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                            <button class="delete-item-mini ml-auto text-red-500 hover:text-red-700 text-xs" data-product-id="{{ $item->product->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                        <div class="p-8 text-center text-gray-500">
                            <i class="fas fa-shopping-cart text-4xl mb-2 opacity-50"></i>
                            <p class="text-sm">Keranjang masih kosong</p>
                        </div>
                        @endif
                    </div>

                    <!-- Cart Summary -->
                    <div class="p-4 border-t">
                        <div class="flex justify-between items-center mb-4">
                            <span class="font-semibold text-gray-900">Total</span>
                            <span class="text-xl font-bold" style="color: #B83556;" id="cart-total">
                                {{ $cartData ? $cartData['formatted_total'] : 'Rp 0' }}
                            </span>
                        </div>
                        <a href="{{ route('cart.index') }}" 
                           class="block w-full text-center text-white py-3 rounded-lg font-semibold transition-colors mb-2"
                           style="background-color: #B83556;">
                            <i class="fas fa-shopping-bag mr-2"></i>Lihat Keranjang
                        </a>
                    </div>
                </div>
            </div>
            @endauth
>>>>>>> 647ab0c7ede6f018197653d397e3f4327fd9d304
        </div>
    </div>
</div>
@endsection

<<<<<<< HEAD
@push('styles')
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        line-clamp: 2;
    }
    
    /* Fallback for browsers that don't support line-clamp */
    @supports not (-webkit-line-clamp: 2) {
        .line-clamp-2 {
            display: block;
            height: 2.5em; /* Approximate height for 2 lines */
            overflow: hidden;
            text-overflow: ellipsis;
        }
    }
</style>
@endpush

@push('scripts')
@auth
<script>
    // Add to cart function
    function addToCart(productId, quantity = 1) {
        // Show loading modal
        document.getElementById('loading-modal').classList.remove('hidden');
        
        fetch('/api/cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                product_id: productId,
                quantity: quantity
            })
        })
        .then(response => {
            // Hide loading modal
            document.getElementById('loading-modal').classList.add('hidden');
            
            // Check if response is ok
            if (!response.ok) {
                return response.json().then(data => {
                    throw new Error(data.message || 'Terjadi kesalahan');
                });
            }
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data); // For debugging
            
            if (data.success) {
                // Show success message
                showMessage('Produk berhasil ditambahkan ke keranjang!', 'success');
                
                // Update cart count
                updateCartCount();
            } else {
                showMessage(data.message || 'Terjadi kesalahan saat menambahkan produk ke keranjang.', 'error');
            }
        })
        .catch(error => {
            // Hide loading modal
            document.getElementById('loading-modal').classList.add('hidden');
            
            console.error('Cart error:', error);
            showMessage(error.message || 'Terjadi kesalahan saat menambahkan produk ke keranjang.', 'error');
        });
    }

    // Show message function
    function showMessage(message, type) {
        const alertClass = type === 'success' ? 'bg-green-100 border-green-400 text-green-700' : 'bg-red-100 border-red-400 text-red-700';
        const iconClass = type === 'success' ? 'fas fa-check-circle' : 'fas fa-exclamation-triangle';
        
        const messageHtml = `
            <div id="dynamic-message" class="${alertClass} border px-4 py-3 rounded relative mx-4 mt-4" role="alert">
                <div class="flex items-center">
                    <i class="${iconClass} mr-2"></i>
                    <span class="block sm:inline">${message}</span>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer" onclick="this.parentElement.parentElement.remove();">
                        <i class="fas fa-times"></i>
                    </span>
                </div>
            </div>
        `;
        
        // Insert message after nav
        const nav = document.querySelector('nav');
        nav.insertAdjacentHTML('afterend', messageHtml);
        
        // Auto-hide after 5 seconds
        setTimeout(() => {
            const message = document.getElementById('dynamic-message');
            if (message) {
                message.remove();
            }
        }, 5000);
    }

    // Update cart count function
    function updateCartCount() {
        fetch('/api/cart/count')
            .then(response => response.json())
            .then(data => {
                document.getElementById('cart-count').textContent = data.count;
            })
            .catch(error => {
                console.error('Error updating cart count:', error);
            });
    }

    // Initial cart count update
    updateCartCount();

    // Add event listeners for add to cart buttons
    document.addEventListener('DOMContentLoaded', function() {
        document.addEventListener('click', function(e) {
            if (e.target.closest('.add-to-cart-btn')) {
                e.preventDefault();
                const button = e.target.closest('.add-to-cart-btn');
                const productId = button.getAttribute('data-product-id');
                if (productId) {
                    addToCart(productId);
                }
            }
        });

        // Auto-submit form when sort changes
        const sortSelect = document.getElementById('sort');
        if (sortSelect) {
            sortSelect.addEventListener('change', function() {
                this.form.submit();
            });
        }

        // Auto-submit form when category changes
        const categorySelect = document.getElementById('category');
        if (categorySelect) {
            categorySelect.addEventListener('change', function() {
                this.form.submit();
            });
        }
    });
</script>
@endauth

<script>
    // Auto-submit form when sort changes (for all users)
    document.addEventListener('DOMContentLoaded', function() {
        const sortSelect = document.getElementById('sort');
        if (sortSelect) {
            sortSelect.addEventListener('change', function() {
                this.form.submit();
            });
        }

        const categorySelect = document.getElementById('category');
        if (categorySelect) {
            categorySelect.addEventListener('change', function() {
                this.form.submit();
            });
        }

        // Live search functionality
        const searchInput = document.getElementById('search-header');
        if (searchInput) {
            let searchTimeout;
            let lastValue = searchInput.value;
            
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                const currentValue = this.value.trim();
                
                // Auto-submit setelah user berhenti mengetik selama 800ms
                // Delay lebih lama memberi waktu untuk menghapus/mengetik beberapa karakter
                searchTimeout = setTimeout(() => {
                    // Hanya submit jika value benar-benar berubah
                    if (currentValue !== lastValue) {
                        lastValue = currentValue;
                        this.form.submit();
                    }
                }, 800);
            });
            
            // Submit langsung saat user menekan Enter
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    clearTimeout(searchTimeout);
                    e.preventDefault();
                    this.form.submit();
                }
            });
        }
    });
</script>
@endpush
=======
@push('scripts')
@auth
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add to cart functionality
    document.querySelectorAll('.add-to-cart-btn').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-product-id');
            addToCart(productId);
        });
    });

    // Quantity decrease
    document.querySelectorAll('.qty-decrease-mini').forEach(btn => {
        btn.addEventListener('click', function() {
            const productId = this.dataset.productId;
            const cartItem = this.closest('.cart-item-mini');
            const qtyDisplay = cartItem.querySelector('.qty-display');
            const currentQty = parseInt(qtyDisplay.textContent);
            
            if (currentQty > 1) {
                updateQuantity(productId, currentQty - 1);
            }
        });
    });

    // Quantity increase
    document.querySelectorAll('.qty-increase-mini').forEach(btn => {
        btn.addEventListener('click', function() {
            const productId = this.dataset.productId;
            const cartItem = this.closest('.cart-item-mini');
            const qtyDisplay = cartItem.querySelector('.qty-display');
            const currentQty = parseInt(qtyDisplay.textContent);
            
            updateQuantity(productId, currentQty + 1);
        });
    });

    // Delete item
    document.querySelectorAll('.delete-item-mini').forEach(btn => {
        btn.addEventListener('click', function() {
            if (confirm('Hapus produk dari keranjang?')) {
                const productId = this.dataset.productId;
                deleteItem(productId);
            }
        });
    });
});

function addToCart(productId) {
    fetch('/api/cart/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: 1
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(data.message, 'success');
            location.reload(); // Refresh to update cart
        } else {
            showNotification(data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Cart error:', error);
        showNotification('Terjadi kesalahan saat menambahkan produk', 'error');
    });
}

function updateQuantity(productId, newQty) {
    fetch(`/cart/${productId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ quantity: newQty })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(data.message, 'success');
            location.reload();
        } else {
            showNotification(data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Terjadi kesalahan saat mengupdate jumlah', 'error');
    });
}

function deleteItem(productId) {
    fetch(`/cart/${productId}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(data.message, 'success');
            location.reload();
        } else {
            showNotification(data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Terjadi kesalahan saat menghapus produk', 'error');
    });
}

function showNotification(message, type) {
    const bgColor = type === 'success' ? '#10B981' : '#EF4444';
    const notification = document.createElement('div');
    notification.style.cssText = `
        position: fixed;
        top: 1rem;
        right: 1rem;
        background-color: ${bgColor};
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 0.5rem;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        z-index: 9999;
        transform: translateX(400px);
        transition: transform 0.3s ease;
    `;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 100);
    
    setTimeout(() => {
        notification.style.transform = 'translateX(400px)';
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 3000);
}
</script>
@endauth
@endpush
>>>>>>> 647ab0c7ede6f018197653d397e3f4327fd9d304
