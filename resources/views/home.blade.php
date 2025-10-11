@extends('app')

@section('title', 'Beranda - Mini Commerce')

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-r from-[#B83556] to-[#FF9CBF] text-white relative overflow-hidden">
    <!-- Sakura Decorations -->
    <div class="absolute inset-0 pointer-events-none">
        <!-- Sakura di kiri atas -->
        <img src="https://raw.githubusercontent.com/twitter/twemoji/master/assets/svg/1f338.svg" 
             alt="sakura" 
             class="absolute top-10 left-10 w-20 h-20 opacity-30 animate-pulse">
        <img src="https://raw.githubusercontent.com/twitter/twemoji/master/assets/svg/1f338.svg" 
             alt="sakura" 
             class="absolute top-32 left-32 w-16 h-16 opacity-20 animate-pulse" 
             style="animation-delay: 0.5s;">
        
        <!-- Sakura di kanan atas -->
        <img src="https://raw.githubusercontent.com/twitter/twemoji/master/assets/svg/1f338.svg" 
             alt="sakura" 
             class="absolute top-16 right-16 w-24 h-24 opacity-50 animate-pulse" 
             style="animation-delay: 1s;">
        <img src="https://raw.githubusercontent.com/twitter/twemoji/master/assets/svg/1f338.svg" 
             alt="sakura" 
             class="absolute top-40 right-40 w-14 h-14 opacity-50 animate-pulse" 
             style="animation-delay: 1.5s;">
        
        <!-- Sakura di kiri bawah -->
        <img src="https://raw.githubusercontent.com/twitter/twemoji/master/assets/svg/1f338.svg" 
             alt="sakura" 
             class="absolute bottom-16 left-20 w-18 h-18 opacity-20 animate-pulse" 
             style="animation-delay: 0.8s;">
        
        <!-- Sakura di kanan bawah -->
        <img src="https://raw.githubusercontent.com/twitter/twemoji/master/assets/svg/1f338.svg" 
             alt="sakura" 
             class="absolute bottom-20 right-24 w-20 h-20 opacity-50 animate-pulse" 
             style="animation-delay: 1.2s;">
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 relative z-10">
        <div class="text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">
                Dukung Produk UMKM Lokal
            </h1>
            <p class="text-xl md:text-2xl mb-8 text-primary-[#FCDD9D]">
                Temukan berbagai produk berkualitas dari usaha kecil menengah terpercaya
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('products.index') }}" 
                   class="bg-white text-[#504E76] px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                    <i class="fas fa-shopping-bag mr-2"></i>Mulai Belanja
                </a>
                @guest
                <a href="{{ route('auth.register') }}" 
                   class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-[#FF9CBF] transition-colors">
                    <i class="fas fa-user-plus mr-2"></i>Daftar Sekarang
                </a>
                @endguest
            </div>
        </div>
    </div>
</div>

<!-- Categories Section -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-gray-900 mb-4">Kategori Produk</h2>
        <p class="text-gray-600 max-w-2xl mx-auto">
            Jelajahi berbagai kategori produk UMKM pilihan yang tersedia
        </p>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
        @foreach($categories as $category)
        <a href="{{ route('products.category', $category->slug) }}" 
           class="group rounded-xl shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1" style="background-color: #FF9CBF;">
            <div class="p-6 text-center">
                <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 transition-colors bg-white">
                    @php
                        $icon = 'fas fa-box'; // default icon
                        if (str_contains(strtolower($category->name), 'makanan') || str_contains(strtolower($category->name), 'minuman')) {
                            $icon = 'fas fa-utensils';
                        } elseif (str_contains(strtolower($category->name), 'fashion') || str_contains(strtolower($category->name), 'pakaian')) {
                            $icon = 'fas fa-tshirt';
                        } elseif (str_contains(strtolower($category->name), 'kerajinan')) {
                            $icon = 'fas fa-palette';
                        } elseif (str_contains(strtolower($category->name), 'kecantikan') || str_contains(strtolower($category->name), 'kesehatan')) {
                            $icon = 'fas fa-spa';
                        } elseif (str_contains(strtolower($category->name), 'elektronik')) {
                            $icon = 'fas fa-mobile-alt';
                        } elseif (str_contains(strtolower($category->name), 'rumah') || str_contains(strtolower($category->name), 'tangga')) {
                            $icon = 'fas fa-home';
                        } elseif (str_contains(strtolower($category->name), 'olahraga') || str_contains(strtolower($category->name), 'outdoor')) {
                            $icon = 'fas fa-running';
                        } elseif (str_contains(strtolower($category->name), 'buku') || str_contains(strtolower($category->name), 'tulis')) {
                            $icon = 'fas fa-book';
                        }
                    @endphp
                    <i class="{{ $icon }} text-2xl" style="color: #B83556;"></i>
                </div>
                <h3 class="font-semibold text-white mb-2 group-hover:text-gray-900 transition-colors">
                    {{ $category->name }}
                </h3>
                <p class="text-sm text-gray-500">
                    {{ $category->active_products_count }} produk
                </p>
            </div>
        </a>
        @endforeach
    </div>
</div>

<!-- Featured Products Section -->
<div class="py-16" style="background-color: #F9CDD5;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Produk Terbaru</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Temukan produk-produk terbaru dan terpopuler dari para pengusaha UMKM
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($featuredProducts as $product)
            <div class="rounded-xl shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 group" style="background-color: #FF9CBF;">
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
                    
                    <h3 class="font-semibold text-white mb-2 group-hover:text-gray-900 transition-colors">
                        <a href="{{ route('products.show', $product->slug) }}">
                            {{ $product->name }}
                        </a>
                    </h3>
                    
                    <p class="text-gray-600 text-sm mb-3 line-clamp-2">
                        {{ Str::limit($product->description, 80) }}
                    </p>
                    
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-lg font-bold text-gray-900">
                            {{ $product->formatted_price }}
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
                                        class="add-to-cart-btn text-white px-4 py-2 rounded-lg transition-colors" style="background-color: #B83556;">
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
                               class="text-white px-4 py-2 rounded-lg transition-colors" style="background-color: #B83556;">
                                <i class="fas fa-cart-plus"></i>
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-12">
            <a href="{{ route('products.index') }}" 
               class="text-white px-8 py-3 rounded-lg font-semibold transition-colors" style="background-color: #B83556;">
                Lihat Semua Produk
                <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>
</div>

<!-- Features Section -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-gray-900 mb-4">Mengapa Memilih Kami?</h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="text-center">
            <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 bg-white">
                <i class="fas fa-shield-alt text-2xl" style="color: #B83556;"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Produk Berkualitas</h3>
            <p class="text-gray-600">
                Semua produk telah melalui kurasi ketat untuk memastikan kualitas terbaik
            </p>
        </div>

        <div class="text-center">
            <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 bg-white">
                <i class="fas fa-shipping-fast text-2xl" style="color: #B83556;"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Pengiriman Cepat</h3>
            <p class="text-gray-600">
                Sistem pengiriman yang efisien untuk memastikan produk sampai dengan aman
            </p>
        </div>

        <div class="text-center">
            <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 bg-white">
                <i class="fas fa-handshake text-2xl" style="color: #B83556;"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Dukung UMKM</h3>
            <p class="text-gray-600">
                Setiap pembelian membantu mengembangkan usaha kecil menengah Indonesia
            </p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
@auth
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add event listeners to all add-to-cart buttons
    document.querySelectorAll('.add-to-cart-btn').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-product-id');
            addToCart(productId);
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
    .then(response => {
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
            showNotification(data.message, 'success');
            // Update cart count immediately (function from app.blade.php)
            if (typeof updateCartCount === 'function') {
                updateCartCount();
            }
        } else {
            showNotification(data.message || 'Terjadi kesalahan', 'error');
        }
    })
    .catch(error => {
        console.error('Cart error:', error);
        showNotification(error.message || 'Terjadi kesalahan saat menambahkan produk', 'error');
    });
}

function showNotification(message, type) {
    const bgColor = type === 'success' ? 'bg-secondary-500' : 'bg-danger-500';
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 ${bgColor} text-white px-6 py-3 rounded-lg shadow-lg z-50 transform translate-x-full transition-transform duration-300`;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    // Slide in
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 100);
    
    // Slide out and remove
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 3000);
}
</script>
@endauth
@endpush