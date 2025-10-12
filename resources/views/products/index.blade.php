@extends('app')

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
        </div>
    </div>
</div>
@endsection

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
