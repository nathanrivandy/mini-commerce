@extends('app')

@section('title', $product->name . ' - Mini Commerce')

@section('content')
<div class="min-h-screen" style="background-color: #F9CDD5;">
    <!-- Breadcrumb -->
    <div class="shadow-sm border-b" style="background-color: #FFB5C8;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <nav class="flex items-center space-x-2 text-sm">
                <a href="{{ route('home') }}" class="text-gray-700 hover:text-gray-900 transition-colors font-medium">
                    <i class="fas fa-home"></i> Home
                </a>
                <span class="text-gray-600">/</span>
                <a href="{{ route('products.index') }}" class="text-gray-700 hover:text-gray-900 transition-colors font-medium">
                    Produk
                </a>
                <span class="text-gray-600">/</span>
                <a href="{{ route('products.category', $product->category->slug) }}" class="text-gray-700 hover:text-gray-900 transition-colors font-medium">
                    {{ $product->category->name }}
                </a>
                <span class="text-gray-600">/</span>
                <span class="text-gray-900 font-bold">{{ $product->name }}</span>
            </nav>
        </div>
    </div>

    <!-- Product Detail Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Product Image -->
            <div class="rounded-lg overflow-hidden shadow-lg h-fit" style="background-color: #FF9CBF;">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" 
                         alt="{{ $product->name }}"
                         class="w-full h-full object-cover">
                @else
                    <div class="w-full h-96 flex items-center justify-center bg-gray-100">
                        <i class="fas fa-image text-gray-400 text-6xl"></i>
                    </div>
                @endif
            </div>

            <!-- Product Information -->
            <div class="rounded-lg shadow-lg p-6 relative" style="background-color: #FF9CBF;">
                <!-- Back Button - Top Right -->
                <div class="absolute top-4 right-4">
                    <a href="{{ route('products.index') }}" 
                       class="inline-flex items-center bg-white text-gray-700 hover:bg-gray-100 px-4 py-2 rounded-lg transition-colors font-medium shadow-sm">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                </div>

                <!-- Category Badge -->
                <div class="mb-4">
                    <a href="{{ route('products.category', $product->category->slug) }}" 
                       class="inline-block text-white text-sm px-3 py-1 rounded-full hover:opacity-80 transition-opacity" 
                       style="background-color: #B83556;">
                        <i class="fas fa-tag mr-1"></i>{{ $product->category->name }}
                    </a>
                </div>

                <!-- Product Name -->
                <h1 class="text-3xl font-bold text-white mb-4">{{ $product->name }}</h1>

                <!-- Product Price -->
                <div class="mb-6">
                    <div class="flex items-baseline space-x-2">
                        <span class="text-4xl font-bold text-gray-900">{{ $product->formatted_price }}</span>
                    </div>
                </div>

                <!-- Stock Status -->
                <div class="mb-6">
                    @if($product->stock > 0)
                        <div class="flex items-center space-x-2 text-green-600">
                            <i class="fas fa-check-circle text-xl"></i>
                            <span class="font-semibold text-lg">Stok Tersedia: {{ $product->stock }} unit</span>
                        </div>
                    @else
                        <div class="flex items-center space-x-2 text-red-600">
                            <i class="fas fa-times-circle text-xl"></i>
                            <span class="font-semibold text-lg">Stok Habis</span>
                        </div>
                    @endif
                </div>

                <!-- Divider -->
                <div class="border-t border-white/30 my-6"></div>

                <!-- Product Description -->
                <div class="mb-6">
                    <h2 class="text-xl font-semibold text-white mb-3">
                        <i class="fas fa-info-circle mr-2"></i>Deskripsi Produk
                    </h2>
                    <div class="bg-white bg-opacity-50 rounded-lg p-4">
                        <p class="text-gray-900 leading-relaxed whitespace-pre-line">{{ $product->description }}</p>
                    </div>
                </div>

                <!-- Divider -->
                <div class="border-t border-white/30 my-6"></div>

                <!-- Add to Cart Section -->
                @auth
                    @if($product->stock > 0)
                        <div class="space-y-4">
                            <!-- Quantity Selector -->
                            <div>
                                <label class="block text-white font-semibold mb-2">
                                    <i class="fas fa-shopping-basket mr-1"></i>Jumlah
                                </label>
                                <div class="flex items-center space-x-3">
                                    <button type="button" 
                                            id="decrease-qty"
                                            class="w-12 h-12 rounded-md bg-white text-gray-700 hover:bg-gray-100 transition-colors flex items-center justify-center font-bold text-xl">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <input type="text" 
                                           id="quantity" 
                                           value="1" 
                                           inputmode="numeric"
                                           pattern="[0-9]*"
                                           class="w-24 text-center border-2 border-white rounded-md py-2 font-semibold text-xl focus:outline-none focus:ring-2 focus:ring-white bg-white">
                                    <button type="button" 
                                            id="increase-qty"
                                            class="w-12 h-12 rounded-md bg-white text-gray-700 hover:bg-gray-100 transition-colors flex items-center justify-center font-bold text-xl">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                    <span class="text-gray-700 text-sm ml-2 font-medium">Maks: {{ $product->stock }}</span>
                                </div>
                            </div>

                            <!-- Add to Cart Button -->
                            <button type="button" 
                                    id="add-to-cart-btn"
                                    data-product-id="{{ $product->id }}"
                                    data-max-stock="{{ $product->stock }}"
                                    class="w-full text-white px-6 py-4 rounded-lg font-bold text-lg transition-colors shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all"
                                    style="background-color: #B83556;"
                                    onmouseover="this.style.backgroundColor='#952B47'"
                                    onmouseout="this.style.backgroundColor='#B83556'">
                                <i class="fas fa-cart-plus mr-2"></i>Tambah ke Keranjang
                            </button>
                        </div>
                    @else
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                <span class="font-semibold">Maaf, produk ini sedang habis.</span>
                            </div>
                        </div>
                    @endif
                @else
                    <div class="space-y-4">
                        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-info-circle mr-2"></i>
                                <span>Silakan login terlebih dahulu untuk menambahkan produk ke keranjang.</span>
                            </div>
                        </div>
                        <a href="{{ route('login') }}" 
                           class="block w-full text-center text-white px-6 py-4 rounded-lg font-bold text-lg transition-colors shadow-lg hover:shadow-xl"
                           style="background-color: #B83556;"
                           onmouseover="this.style.backgroundColor='#952B47'"
                           onmouseout="this.style.backgroundColor='#B83556'">
                            <i class="fas fa-sign-in-alt mr-2"></i>Login Sekarang
                        </a>
                    </div>
                @endauth
            </div>
        </div>

        <!-- Related Products Section -->
        @if($relatedProducts && $relatedProducts->count() > 0)
        <div class="mt-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">
                <i class="fas fa-box-open mr-2"></i>Produk Terkait
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts as $relatedProduct)
                    <a href="{{ route('products.show', $relatedProduct->slug) }}" 
                       class="rounded-lg shadow-sm hover:shadow-lg transition-all duration-200 overflow-hidden group block cursor-pointer transform hover:-translate-y-1" 
                       style="background-color: #FF9CBF;">
                        <!-- Product Image -->
                        <div class="aspect-w-1 aspect-h-1 bg-gray-200 overflow-hidden relative">
                            @if($relatedProduct->image)
                                <img src="{{ asset('storage/' . $relatedProduct->image) }}" 
                                     alt="{{ $relatedProduct->name }}"
                                     class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-300">
                            @else
                                <div class="w-full h-48 flex items-center justify-center bg-gray-100">
                                    <i class="fas fa-image text-gray-400 text-4xl"></i>
                                </div>
                            @endif
                            
                            @if($relatedProduct->stock <= 0)
                                <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                                    <span class="bg-red-600 text-white px-4 py-2 rounded-full font-semibold text-sm">
                                        <i class="fas fa-times-circle mr-1"></i>Stok Habis
                                    </span>
                                </div>
                            @endif
                        </div>

                        <!-- Product Info -->
                        <div class="p-4">
                            <div class="mb-2">
                                <span class="inline-block text-white text-xs px-2 py-1 rounded-full" style="background-color: #B83556;">
                                    {{ $relatedProduct->category->name }}
                                </span>
                            </div>

                            <h3 class="text-lg font-semibold text-white mb-2 group-hover:text-gray-900 transition-colors line-clamp-1">
                                {{ $relatedProduct->name }}
                            </h3>

                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xl font-bold text-gray-900">{{ $relatedProduct->formatted_price }}</span>
                            </div>

                            <!-- Stock Info -->
                            <div class="flex items-center">
                                @if($relatedProduct->stock > 0)
                                    <span class="text-sm text-green-600 font-medium">
                                        <i class="fas fa-check-circle mr-1"></i>Stok: {{ $relatedProduct->stock }} unit
                                    </span>
                                @else
                                    <span class="text-sm text-red-600 font-medium">
                                        <i class="fas fa-times-circle mr-1"></i>Stok Habis
                                    </span>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Loading Modal -->
<div id="loading-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-1/2 mx-auto p-5 border w-80 shadow-lg rounded-md bg-white transform -translate-y-1/2">
        <div class="text-center">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 mx-auto mb-4" style="border-color: #B83556;"></div>
            <h3 class="text-lg font-medium text-gray-900">Menambahkan ke keranjang...</h3>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .line-clamp-1 {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    /* Remove spinner from number input */
    input[type="text"]#quantity::-webkit-outer-spin-button,
    input[type="text"]#quantity::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    
    input[type="text"]#quantity {
        -moz-appearance: textfield;
        appearance: textfield;
    }
    
    /* Remove extra space below image */
    img {
        display: block;
        max-width: 100%;
        height: auto;
    }
</style>
@endpush

@push('scripts')
@auth
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const quantityInput = document.getElementById('quantity');
        const decreaseBtn = document.getElementById('decrease-qty');
        const increaseBtn = document.getElementById('increase-qty');
        const addToCartBtn = document.getElementById('add-to-cart-btn');
        
        // Get max stock from data attribute
        const maxStock = addToCartBtn ? parseInt(addToCartBtn.getAttribute('data-max-stock')) : 1;

        // Decrease quantity
        if (decreaseBtn) {
            decreaseBtn.addEventListener('click', function() {
                let currentValue = parseInt(quantityInput.value);
                if (currentValue > 1) {
                    quantityInput.value = currentValue - 1;
                }
            });
        }

        // Increase quantity
        if (increaseBtn) {
            increaseBtn.addEventListener('click', function() {
                let currentValue = parseInt(quantityInput.value);
                if (currentValue < maxStock) {
                    quantityInput.value = currentValue + 1;
                }
            });
        }

        // Validate quantity input - allow only numbers
        if (quantityInput) {
            quantityInput.addEventListener('input', function(e) {
                // Remove any non-numeric characters
                let value = this.value.replace(/[^0-9]/g, '');
                
                // If empty or invalid, set to empty string temporarily
                if (value === '') {
                    this.value = '';
                    return;
                }
                
                // Parse and validate
                let numValue = parseInt(value);
                
                if (numValue < 1) {
                    this.value = '1';
                } else if (numValue > maxStock) {
                    this.value = maxStock.toString();
                } else {
                    this.value = numValue.toString();
                }
            });
            
            // On blur, ensure there's always a valid value
            quantityInput.addEventListener('blur', function() {
                if (this.value === '' || parseInt(this.value) < 1) {
                    this.value = '1';
                }
            });
        }

        // Add to cart
        if (addToCartBtn) {
            addToCartBtn.addEventListener('click', function() {
                const productId = this.getAttribute('data-product-id');
                const quantity = parseInt(quantityInput.value);
                addToCart(productId, quantity);
            });
        }
    });

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
            
            if (!response.ok) {
                return response.json().then(data => {
                    throw new Error(data.message || 'Terjadi kesalahan');
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                showMessage('Produk berhasil ditambahkan ke keranjang!', 'success');
                updateCartCount();
                
                // Reset quantity to 1
                document.getElementById('quantity').value = 1;
            } else {
                showMessage(data.message || 'Terjadi kesalahan saat menambahkan produk ke keranjang.', 'error');
            }
        })
        .catch(error => {
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
        
        const nav = document.querySelector('nav');
        if (nav) {
            nav.insertAdjacentHTML('afterend', messageHtml);
        }
        
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
                const cartCount = document.getElementById('cart-count');
                if (cartCount) {
                    cartCount.textContent = data.count;
                }
            })
            .catch(error => {
                console.error('Error updating cart count:', error);
            });
    }
</script>
@endauth
@endpush
