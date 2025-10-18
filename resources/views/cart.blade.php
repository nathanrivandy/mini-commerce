@extends('app')

@section('title', 'Keranjang Belanja - Riloka')

@section('content')
<div class="min-h-screen py-8 relative overflow-hidden" style="background-color: #F9CDD5;">
    <!-- Sakura Decorations -->
    <div class="absolute inset-0 pointer-events-none">
        <!-- Sakura di kiri atas -->
        <img src="https://raw.githubusercontent.com/twitter/twemoji/master/assets/svg/1f338.svg" 
             alt="sakura" 
             class="absolute top-10 left-10 w-14 h-14 opacity-20 animate-pulse">
        <img src="https://raw.githubusercontent.com/twitter/twemoji/master/assets/svg/1f338.svg" 
             alt="sakura" 
             class="absolute top-32 left-32 w-12 h-12 opacity-15 animate-pulse" 
             style="animation-delay: 0.5s;">
        
        <!-- Sakura di kanan atas -->
        <img src="https://raw.githubusercontent.com/twitter/twemoji/master/assets/svg/1f338.svg" 
             alt="sakura" 
             class="absolute top-20 right-20 w-14 h-14 opacity-20 animate-pulse" 
             style="animation-delay: 1s;">
        
        <!-- Sakura di kiri bawah -->
        <img src="https://raw.githubusercontent.com/twitter/twemoji/master/assets/svg/1f338.svg" 
             alt="sakura" 
             class="absolute bottom-20 left-20 w-12 h-12 opacity-15 animate-pulse" 
             style="animation-delay: 0.8s;">
        
        <!-- Sakura di kanan bawah -->
        <img src="https://raw.githubusercontent.com/twitter/twemoji/master/assets/svg/1f338.svg" 
             alt="sakura" 
             class="absolute bottom-32 right-32 w-14 h-14 opacity-20 animate-pulse" 
             style="animation-delay: 1.2s;">
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Header -->
        <div class="mb-8 pt-8">
            <h1 class="text-3xl font-bold text-gray-900">Keranjang Belanja</h1>
            <p class="text-gray-600 mt-2">Kelola produk yang akan Anda beli</p>
        </div>

        @if(isset($items) && count($items) > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Cart Items -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <!-- Select All Header -->
                    <div class="p-4 border-b flex items-center justify-between" style="background-color: #FF9CBF;">
                        <div class="flex items-center space-x-3">
                            <input type="checkbox" 
                                   id="select-all" 
                                   class="w-5 h-5 rounded border-gray-300 focus:ring-2 cursor-pointer"
                                   style="accent-color: #B83556;">
                            <label for="select-all" class="text-white font-semibold cursor-pointer">
                                Pilih Semua ({{ count($items) }} Produk)
                            </label>
                        </div>
                        <button id="delete-selected" 
                                class="text-white hover:text-gray-900 transition-colors px-3 py-1 rounded hidden">
                            <i class="fas fa-trash mr-1"></i>Hapus Terpilih
                        </button>
                    </div>

                    <!-- Cart Items List -->
                    <div id="cart-items-container">
                        @foreach($items as $item)
                        <div class="cart-item p-4 border-b hover:bg-gray-50 transition-colors" 
                             data-item-id="{{ $item->product->id }}"
                             data-price="{{ $item->product->price }}"
                             data-stock="{{ $item->product->stock }}">
                            <div class="flex items-start space-x-4">
                                <!-- Checkbox -->
                                <div class="flex items-center pt-2">
                                    <input type="checkbox" 
                                           class="item-checkbox w-5 h-5 rounded border-gray-300 focus:ring-2 cursor-pointer"
                                           style="accent-color: #B83556;"
                                           data-product-id="{{ $item->product->id }}">
                                </div>

                                <!-- Product Image -->
                                <div class="flex-shrink-0">
                                    <img src="{{ $item->product->image ? asset('storage/' . $item->product->image) : 'https://via.placeholder.com/100' }}" 
                                         alt="{{ $item->product->name }}"
                                         class="w-24 h-24 object-cover rounded-lg">
                                </div>

                                <!-- Product Info -->
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-1">
                                        {{ $item->product->name }}
                                    </h3>
                                    <p class="text-sm text-gray-500 mb-2">
                                        {{ $item->product->category->name }}
                                    </p>
                                    <p class="text-lg font-bold mb-3" style="color: #B83556;">
                                        Rp {{ number_format($item->product->price, 0, ',', '.') }}
                                    </p>

                                    <!-- Quantity Controls -->
                                    <div class="flex items-center space-x-3">
                                        <div class="flex items-center space-x-2">
                                            <button type="button"
                                                    class="qty-decrease w-8 h-8 rounded-md bg-gray-100 text-gray-700 hover:bg-gray-200 transition-colors flex items-center justify-center font-bold"
                                                    data-product-id="{{ $item->product->id }}">
                                                <i class="fas fa-minus text-xs"></i>
                                            </button>
                                            <input type="text" 
                                                   class="qty-input w-16 text-center border-2 border-gray-300 rounded-md py-1.5 font-semibold text-base focus:outline-none focus:ring-2 focus:ring-pink-500 bg-white"
                                                   value="{{ $item->qty }}"
                                                   inputmode="numeric"
                                                   pattern="[0-9]*"
                                                   data-product-id="{{ $item->product->id }}"
                                                   data-max="{{ $item->product->stock }}"
                                                   readonly>
                                            <button type="button"
                                                    class="qty-increase w-8 h-8 rounded-md bg-gray-100 text-gray-700 hover:bg-gray-200 transition-colors flex items-center justify-center font-bold"
                                                    data-product-id="{{ $item->product->id }}">
                                                <i class="fas fa-plus text-xs"></i>
                                            </button>
                                        </div>
                                        <span class="text-sm text-gray-500 font-medium">
                                            Maks: {{ $item->product->stock }}
                                        </span>
                                    </div>

                                    @if($item->qty > $item->product->stock)
                                    <p class="text-red-500 text-sm mt-2">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        Jumlah melebihi stok tersedia
                                    </p>
                                    @endif
                                </div>

                                <!-- Delete Button -->
                                <button class="delete-item text-gray-400 hover:text-red-500 transition-colors p-2"
                                        data-product-id="{{ $item->product->id }}">
                                    <i class="fas fa-trash text-lg"></i>
                                </button>
                            </div>

                            <!-- Item Subtotal -->
                            <div class="mt-3 text-right">
                                <span class="text-sm text-gray-600">Subtotal: </span>
                                <span class="text-lg font-bold item-subtotal" style="color: #B83556;">
                                    Rp {{ number_format($item->product->price * $item->qty, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-md p-6 sticky top-24">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Ringkasan Belanja</h2>
                    
                    <div class="space-y-3 mb-4">
                        <div class="flex justify-between text-gray-600">
                            <span>Produk Dipilih</span>
                            <span id="selected-count">0</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Total Harga</span>
                            <span id="selected-total">Rp 0</span>
                        </div>
                    </div>

                    <div class="border-t pt-4 mb-6">
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-semibold text-gray-900">Total</span>
                            <span class="text-2xl font-bold" style="color: #B83556;" id="grand-total">Rp 0</span>
                        </div>
                    </div>

                    <button id="checkout-btn" 
                            class="w-full text-white py-3 rounded-lg font-semibold transition-colors mb-3 disabled:opacity-50 disabled:cursor-not-allowed"
                            style="background-color: #B83556;"
                            disabled>
                        <i class="fas fa-shopping-bag mr-2"></i>
                        Checkout (<span id="checkout-count">0</span>)
                    </button>

                    <a href="{{ route('products.index') }}" 
                       class="block w-full text-center border-2 py-3 rounded-lg font-semibold transition-colors"
                       style="border-color: #B83556; color: #B83556;">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Lanjut Belanja
                    </a>
                </div>
            </div>
        </div>
        @else
        <!-- Empty Cart -->
        <div class="bg-white rounded-xl shadow-md p-12 text-center">
            <div class="mb-6">
                <i class="fas fa-shopping-cart text-gray-300 text-6xl"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Keranjang Belanja Kosong</h2>
            <p class="text-gray-600 mb-6">Anda belum menambahkan produk apapun ke keranjang</p>
            <a href="{{ route('products.index') }}" 
               class="inline-block text-white px-8 py-3 rounded-lg font-semibold transition-colors"
               style="background-color: #B83556;">
                <i class="fas fa-shopping-bag mr-2"></i>
                Mulai Belanja
            </a>
        </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Remove spinner from number input */
    input[type="text"].qty-input::-webkit-outer-spin-button,
    input[type="text"].qty-input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    
    input[type="text"].qty-input {
        -moz-appearance: textfield;
        appearance: textfield;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Validate quantity input - allow only numbers (similar to products.show)
    document.querySelectorAll('.qty-input').forEach(input => {
        input.addEventListener('input', function(e) {
            const maxStock = parseInt(this.getAttribute('data-max'));
            
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
                showNotification('Jumlah tidak boleh melebihi stok tersedia', 'error');
            } else {
                this.value = numValue.toString();
            }
        });
        
        // On blur, ensure there's always a valid value
        input.addEventListener('blur', function() {
            if (this.value === '' || parseInt(this.value) < 1) {
                this.value = '1';
            }
            
            // Update quantity via API when input loses focus
            const productId = this.getAttribute('data-product-id');
            const newQty = parseInt(this.value);
            const cartItem = this.closest('.cart-item');
            const currentQtyInDOM = parseInt(cartItem.querySelector('.qty-input').value);
            
            // Only update if value changed
            if (newQty !== currentQtyInDOM) {
                updateQuantity(productId, newQty);
            }
        });
    });

    // Custom Confirm Dialog with Pink Theme
    function showCustomConfirm(message, onConfirm) {
        // Create overlay
        const overlay = document.createElement('div');
        overlay.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
        overlay.style.animation = 'fadeIn 0.2s ease-out';
        
        // Create dialog
        const dialog = document.createElement('div');
        dialog.className = 'bg-white rounded-lg shadow-2xl p-6 max-w-sm w-full mx-4';
        dialog.style.animation = 'slideIn 0.3s ease-out';
        
        dialog.innerHTML = `
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full mb-4" style="background-color: #F9CDD5;">
                    <svg class="h-6 w-6" style="color: #B83556;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </div>
                <p class="text-lg font-medium text-gray-900 mb-6">${message}</p>
                <div class="flex gap-3">
                    <button class="cancel-btn flex-1 px-4 py-2 rounded-lg font-medium transition-all duration-200 hover:opacity-90" 
                            style="background-color: #F9CDD5; color: #B83556;">
                        Batal
                    </button>
                    <button class="confirm-btn flex-1 px-4 py-2 rounded-lg font-medium text-white transition-all duration-200 hover:opacity-90" 
                            style="background-color: #B83556;">
                        Hapus
                    </button>
                </div>
            </div>
        `;
        
        overlay.appendChild(dialog);
        document.body.appendChild(overlay);
        
        // Add animations
        const style = document.createElement('style');
        style.textContent = `
            @keyframes fadeIn {
                from { opacity: 0; }
                to { opacity: 1; }
            }
            @keyframes slideIn {
                from { transform: translateY(-20px) scale(0.95); opacity: 0; }
                to { transform: translateY(0) scale(1); opacity: 1; }
            }
        `;
        document.head.appendChild(style);
        
        // Handle buttons
        const cancelBtn = dialog.querySelector('.cancel-btn');
        const confirmBtn = dialog.querySelector('.confirm-btn');
        
        const closeDialog = () => {
            overlay.style.animation = 'fadeIn 0.2s ease-out reverse';
            setTimeout(() => overlay.remove(), 200);
        };
        
        cancelBtn.addEventListener('click', closeDialog);
        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) closeDialog();
        });
        
        confirmBtn.addEventListener('click', () => {
            closeDialog();
            onConfirm();
        });
    }

    const selectAllCheckbox = document.getElementById('select-all');
    const itemCheckboxes = document.querySelectorAll('.item-checkbox');
    const deleteSelectedBtn = document.getElementById('delete-selected');
    const checkoutBtn = document.getElementById('checkout-btn');

    // Update summary based on selected items
    function updateSummary() {
        let selectedCount = 0;
        let selectedTotal = 0;
        
        itemCheckboxes.forEach(checkbox => {
            if (checkbox.checked) {
                const cartItem = checkbox.closest('.cart-item');
                const price = parseFloat(cartItem.dataset.price);
                const qtyInput = cartItem.querySelector('.qty-input');
                const qty = parseInt(qtyInput.value);
                
                selectedCount++;
                selectedTotal += price * qty;
            }
        });

        document.getElementById('selected-count').textContent = selectedCount;
        document.getElementById('selected-total').textContent = formatRupiah(selectedTotal);
        document.getElementById('grand-total').textContent = formatRupiah(selectedTotal);
        document.getElementById('checkout-count').textContent = selectedCount;

        // Enable/disable checkout button
        checkoutBtn.disabled = selectedCount === 0;

        // Show/hide delete selected button
        if (selectedCount > 0) {
            deleteSelectedBtn.classList.remove('hidden');
        } else {
            deleteSelectedBtn.classList.add('hidden');
        }
    }

    // Format number to Rupiah
    function formatRupiah(number) {
        return 'Rp ' + number.toLocaleString('id-ID');
    }

    // Select all functionality
    selectAllCheckbox.addEventListener('change', function() {
        itemCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateSummary();
    });

    // Individual checkbox change
    itemCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const allChecked = Array.from(itemCheckboxes).every(cb => cb.checked);
            selectAllCheckbox.checked = allChecked;
            updateSummary();
        });
    });

    // Quantity decrease
    document.querySelectorAll('.qty-decrease').forEach(btn => {
        btn.addEventListener('click', function() {
            const productId = this.dataset.productId;
            const input = document.querySelector(`.qty-input[data-product-id="${productId}"]`);
            const currentQty = parseInt(input.value);
            
            if (currentQty > 1) {
                updateQuantity(productId, currentQty - 1);
            }
        });
    });

    // Quantity increase
    document.querySelectorAll('.qty-increase').forEach(btn => {
        btn.addEventListener('click', function() {
            const productId = this.dataset.productId;
            const input = document.querySelector(`.qty-input[data-product-id="${productId}"]`);
            const cartItem = this.closest('.cart-item');
            const stock = parseInt(cartItem.dataset.stock);
            const currentQty = parseInt(input.value);
            
            if (currentQty < stock) {
                updateQuantity(productId, currentQty + 1);
            } else {
                showNotification('Jumlah tidak boleh melebihi stok tersedia', 'error');
            }
        });
    });

    // Update quantity via API
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
                const input = document.querySelector(`.qty-input[data-product-id="${productId}"]`);
                input.value = newQty;
                
                // Update item subtotal
                const cartItem = input.closest('.cart-item');
                const price = parseFloat(cartItem.dataset.price);
                const subtotal = price * newQty;
                cartItem.querySelector('.item-subtotal').textContent = formatRupiah(subtotal);
                
                updateSummary();
                showNotification(data.message, 'success');
                
                // Update cart count
                if (typeof updateCartCount === 'function') {
                    updateCartCount();
                }
            } else {
                showNotification(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Terjadi kesalahan saat mengupdate jumlah', 'error');
        });
    }

    // Delete single item
    document.querySelectorAll('.delete-item').forEach(btn => {
        btn.addEventListener('click', function() {
            const productId = this.dataset.productId;
            showCustomConfirm('Apakah Anda yakin ingin menghapus produk ini dari keranjang?', () => {
                deleteItem(productId);
            });
        });
    });

    // Delete selected items
    deleteSelectedBtn.addEventListener('click', function() {
        const selectedItems = Array.from(itemCheckboxes)
            .filter(cb => cb.checked)
            .map(cb => cb.dataset.productId);
        
        if (selectedItems.length === 0) return;
        
        showCustomConfirm(`Hapus ${selectedItems.length} produk dari keranjang?`, () => {
            // Delete all selected items at once
            const deletePromises = selectedItems.map(productId => 
                fetch(`/cart/${productId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                }).then(response => response.json())
            );
            
            Promise.all(deletePromises)
                .then(results => {
                    const allSuccess = results.every(result => result.success);
                    if (allSuccess) {
                        showNotification(`${selectedItems.length} produk berhasil dihapus`, 'success');
                        location.reload();
                    } else {
                        showNotification('Beberapa produk gagal dihapus', 'error');
                        location.reload();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Terjadi kesalahan saat menghapus produk', 'error');
                });
        });
    });

    // Delete item via API
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
                // Remove item from DOM
                const cartItem = document.querySelector(`.cart-item[data-item-id="${productId}"]`);
                cartItem.remove();
                
                // Check if cart is empty
                const remainingItems = document.querySelectorAll('.cart-item');
                if (remainingItems.length === 0) {
                    location.reload();
                }
                
                updateSummary();
                showNotification(data.message, 'success');
                
                // Update cart count
                if (typeof updateCartCount === 'function') {
                    updateCartCount();
                }
            } else {
                showNotification(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Terjadi kesalahan saat menghapus produk', 'error');
        });
    }

    // Checkout
    checkoutBtn.addEventListener('click', function() {
        const selectedItems = Array.from(itemCheckboxes)
            .filter(cb => cb.checked)
            .map(cb => {
                const cartItem = cb.closest('.cart-item');
                const qtyInput = cartItem.querySelector('.qty-input');
                return {
                    product_id: cb.dataset.productId,
                    quantity: parseInt(qtyInput.value)
                };
            });
        
        if (selectedItems.length === 0) {
            showNotification('Pilih minimal 1 produk untuk checkout', 'error');
            return;
        }

        // Redirect to checkout page
        window.location.href = '{{ route("checkout.index") }}';
    });

    // Show notification
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

    // Initialize summary on page load
    updateSummary();
});
</script>
@endpush
