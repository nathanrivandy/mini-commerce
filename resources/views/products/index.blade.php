@extends('app')

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
                <div class="flex-grow max-w-md">
                    <form action="{{ route('products.search') }}" method="GET" id="search-form">
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
                        
                        <div class="relative w-full">
                            <input type="text" 
                                   id="search-header" 
                                   name="search" 
                                   value="{{ request('search') }}"
                                   placeholder="Ketik untuk mencari produk..."
                                   class="w-full pl-10 pr-10 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:border-transparent">
                            <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            @if(request('search'))
                                <button type="button" 
                                        id="clear-search"
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
                    <!-- Filter Section -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                            <i class="fas fa-filter mr-2"></i>Filter Produk
                        </h3>
                        
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
                                <label for="category" class="block text-sm font-medium text-white mb-2">
                                    <i class="fas fa-tags mr-1"></i>Kategori
                                </label>
                                <select id="category" 
                                        name="category" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
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
                                <label class="block text-sm font-medium text-white mb-2">
                                    <i class="fas fa-money-bill-wave mr-1"></i>Rentang Harga
                                </label>
                                <div class="grid grid-cols-2 gap-2">
                                    <input type="number" 
                                           name="min_price" 
                                           placeholder="Min"
                                           value="{{ request('min_price') }}"
                                           class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm bg-white">
                                    <input type="number" 
                                           name="max_price" 
                                           placeholder="Max"
                                           value="{{ request('max_price') }}"
                                           class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm bg-white">
                                </div>
                            </div>

                            <!-- Sort Options -->
                            <div>
                                <label for="sort" class="block text-sm font-medium text-white mb-2">
                                    <i class="fas fa-sort mr-1"></i>Urutkan
                                </label>
                                <select id="sort" 
                                        name="sort" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                                    <option value="">Pilih Urutan</option>
                                    <optgroup label="Harga">
                                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Harga: Terendah ke Tertinggi</option>
                                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Harga: Tertinggi ke Terendah</option>
                                    </optgroup>
                                    <optgroup label="Nama">
                                        <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nama: A - Z</option>
                                        <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Nama: Z - A</option>
                                    </optgroup>
                                    <optgroup label="Lainnya">
                                        <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Terbaru</option>
                                    </optgroup>
                                </select>
                            </div>

                            <div class="flex space-x-2">
                                <button type="submit" 
                                        class="flex-1 text-white px-4 py-2 rounded-md transition-colors font-medium"
                                        style="background-color: #B83556;"
                                        onmouseover="this.style.backgroundColor='#952B47'"
                                        onmouseout="this.style.backgroundColor='#B83556'">
                                    <i class="fas fa-filter mr-1"></i>Terapkan
                                </button>
                                <a href="{{ route('products.index') }}" 
                                   class="flex-1 bg-white text-gray-700 px-4 py-2 rounded-md hover:bg-gray-100 transition-colors text-center font-medium">
                                    Reset
                                </a>
                            </div>
                        </form>
                    </div>

                    <!-- Divider -->
                    <div class="border-t border-white/30 my-6"></div>

                    <!-- Category Quick Links Section -->
                    <div>
                        <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                            <i class="fas fa-star mr-2"></i>Kategori Populer
                        </h3>
                        <div class="space-y-2">
                            @foreach($categories->take(8) as $cat)
                                <a href="{{ route('products.category', $cat->slug) }}" 
                                   class="block px-3 py-2 text-sm text-gray-700 bg-white hover:bg-gray-100 rounded-md transition-colors {{ (isset($category) && $category->id == $cat->id) ? 'bg-white ring-2 ring-offset-2 ring-white font-semibold' : '' }}">
                                    <i class="fas fa-tag mr-2 text-xs"></i>{{ $cat->name }}
                                    <span class="text-xs text-gray-500 float-right">({{ $cat->products_count ?? $cat->activeProducts->count() }})</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="lg:col-span-3">
                @if($products->count() > 0)
                    <!-- Products Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach($products as $product)
                            <a href="{{ route('products.show', $product->slug) }}" 
                               class="rounded-lg shadow-sm hover:shadow-lg transition-all duration-200 overflow-hidden group block cursor-pointer transform hover:-translate-y-1" 
                               style="background-color: #FF9CBF;">
                                <!-- Product Image -->
                                <div class="aspect-w-1 aspect-h-1 bg-gray-200 overflow-hidden relative">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" 
                                             alt="{{ $product->name }}"
                                             class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-300">
                                    @else
                                        <div class="w-full h-48 flex items-center justify-center bg-gray-100">
                                            <i class="fas fa-image text-gray-400 text-4xl"></i>
                                        </div>
                                    @endif
                                    
                                    <!-- Stock Badge Overlay -->
                                    @if($product->stock <= 0)
                                        <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                                            <span class="bg-red-600 text-white px-4 py-2 rounded-full font-semibold">
                                                <i class="fas fa-times-circle mr-1"></i>Stok Habis
                                            </span>
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
                                        {{ $product->name }}
                                    </h3>

                                    <!-- Product Description -->
                                    <p class="text-gray-700 text-sm mb-3 line-clamp-2">
                                        {{ Str::limit($product->description, 80) }}
                                    </p>

                                    <!-- Price and Stock -->
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <span class="text-xl font-bold text-gray-900">{{ $product->formatted_price }}</span>
                                        </div>
                                        @if($product->stock > 0)
                                            <div class="text-right">
                                                <span class="text-sm text-green-600 font-medium">
                                                    <i class="fas fa-check-circle mr-1"></i>Stok: {{ $product->stock }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if($products->hasPages())
                    <div class="mt-8 rounded-lg shadow-sm p-6" style="background-color: #FF9CBF;">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <p class="text-sm font-medium text-white">
                                    Menampilkan <span class="font-bold">{{ $products->firstItem() }}</span> sampai <span class="font-bold">{{ $products->lastItem() }}</span> dari <span class="font-bold">{{ $products->total() }}</span> produk
                                </p>
                            </div>
                            <div class="flex space-x-1">
                                @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                                    @if ($page == $products->currentPage())
                                        <span class="px-4 py-2 text-sm font-bold text-white rounded-lg shadow-md" style="background-color: #B83556;">
                                            {{ $page }}
                                        </span>
                                    @else
                                        <a href="{{ $url }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white rounded-lg hover:bg-gray-100 transition-colors shadow-sm">
                                            {{ $page }}
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif
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
        </div>
    </div>
</div>
@endsection

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

        // Live search functionality with debouncing
        const searchInput = document.getElementById('search-header');
        const searchForm = document.getElementById('search-form');
        const clearButton = document.getElementById('clear-search');
        
        if (searchInput) {
            let searchTimeout;
            
            // Debounced search - tunggu 1.5 detik setelah user berhenti mengetik
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                
                const searchValue = this.value.trim();
                
                // Jika search kosong, langsung submit
                if (searchValue === '') {
                    searchForm.submit();
                    return;
                }
                
                // Tunggu 1500ms (1.5 detik) setelah user berhenti mengetik
                searchTimeout = setTimeout(() => {
                    searchForm.submit();
                }, 1500);
            });
            
            // Submit langsung saat user menekan Enter
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    clearTimeout(searchTimeout);
                    e.preventDefault();
                    searchForm.submit();
                }
            });
        }
        
        // Clear search functionality
        if (clearButton) {
            clearButton.addEventListener('click', function() {
                searchInput.value = '';
                searchForm.submit();
            });
        }
    });
</script>
@endpush
