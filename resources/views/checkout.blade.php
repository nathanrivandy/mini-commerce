@extends('app')

@section('title', 'Checkout - Riloka')

@section('content')
<div class="min-h-screen py-8 relative overflow-hidden" style="background-color: #F9CDD5;">
    <!-- Sakura Decorations -->
    <div class="absolute inset-0 pointer-events-none">
        <!-- Sakura di kiri atas -->
        <img src="https://raw.githubusercontent.com/twitter/twemoji/master/assets/svg/1f338.svg" 
             alt="sakura" 
             class="absolute top-10 left-10 w-14 h-14 opacity-20 animate-pulse">
        
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
            <!-- Breadcrumb -->
            <div class="mb-4">
                <p class="text-gray-600">
                    <a href="{{ route('home') }}" class="text-[#B83556] hover:text-[#FF9CBF]">
                        <i class="fas fa-home mr-1"></i>Beranda
                    </a> 
                    <span class="mx-2">/</span>
                    <a href="{{ route('cart.index') }}" class="text-[#B83556] hover:text-[#FF9CBF]">
                        <i class="fas fa-shopping-cart mr-1"></i>Keranjang
                    </a> 
                    <span class="mx-2">/</span>
                    <span class="text-gray-900 font-medium">Checkout</span>
                </p>
            </div>

            <h1 class="text-3xl font-bold text-gray-900">Checkout</h1>
            <p class="text-gray-600 mt-2">Lengkapi informasi pengiriman dan pembayaran Anda</p>
        </div>

        <form action="{{ route('checkout.store') }}" method="POST" id="checkout-form">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column - Forms -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- Shipping Address -->
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-map-marker-alt mr-2" style="color: #B83556;"></i>
                            Alamat Pengiriman
                        </h2>
                        
                        <div class="space-y-4">
                            <!-- Nama Penerima -->
                            <div>
                                <label for="recipient_name" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-user mr-1 text-[#B83556]"></i>Nama Penerima
                                </label>
                                <input type="text" 
                                       id="recipient_name" 
                                       name="recipient_name" 
                                       value="{{ old('recipient_name', Auth::user()->name) }}"
                                       required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#B83556] focus:border-transparent transition-colors @error('recipient_name') border-red-500 @enderror" 
                                       placeholder="Masukkan nama penerima">
                                @error('recipient_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nomor Telepon -->
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-phone mr-1 text-[#B83556]"></i>Nomor Telepon
                                </label>
                                <input type="tel" 
                                       id="phone" 
                                       name="phone" 
                                       value="{{ old('phone') }}"
                                       required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#B83556] focus:border-transparent transition-colors @error('phone') border-red-500 @enderror" 
                                       placeholder="Contoh: 081234567890">
                                @error('phone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Alamat Lengkap -->
                            <div>
                                <label for="shipping_address" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-home mr-1 text-[#B83556]"></i>Alamat Lengkap
                                </label>
                                <textarea id="shipping_address" 
                                          name="shipping_address" 
                                          rows="3" 
                                          required
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#B83556] focus:border-transparent transition-colors @error('shipping_address') border-red-500 @enderror" 
                                          placeholder="Jalan, nomor rumah, RT/RW, Kelurahan, Kecamatan">{{ old('shipping_address') }}</textarea>
                                @error('shipping_address')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Kota & Kode Pos -->
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="city" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-city mr-1 text-[#B83556]"></i>Kota
                                    </label>
                                    <input type="text" 
                                           id="city" 
                                           name="city" 
                                           value="{{ old('city') }}"
                                           required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#B83556] focus:border-transparent transition-colors @error('city') border-red-500 @enderror" 
                                           placeholder="Nama kota">
                                    @error('city')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-mail-bulk mr-1 text-[#B83556]"></i>Kode Pos
                                    </label>
                                    <input type="text" 
                                           id="postal_code" 
                                           name="postal_code" 
                                           value="{{ old('postal_code') }}"
                                           required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#B83556] focus:border-transparent transition-colors @error('postal_code') border-red-500 @enderror" 
                                           placeholder="12345">
                                    @error('postal_code')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Catatan (Opsional) -->
                            <div>
                                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-sticky-note mr-1 text-[#B83556]"></i>Catatan untuk Penjual (Opsional)
                                </label>
                                <textarea id="notes" 
                                          name="notes" 
                                          rows="2" 
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#B83556] focus:border-transparent transition-colors" 
                                          placeholder="Contoh: Tolong kemas dengan bubble wrap">{{ old('notes') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-credit-card mr-2" style="color: #B83556;"></i>
                            Metode Pembayaran
                        </h2>
                        
                        <div class="space-y-3">
                            <!-- Bank Transfer -->
                            <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-[#B83556] transition-colors payment-option">
                                <input type="radio" 
                                       name="payment_method" 
                                       value="bank_transfer" 
                                       class="w-5 h-5 text-[#B83556] focus:ring-[#B83556]" 
                                       checked
                                       style="accent-color: #B83556;">
                                <div class="ml-4 flex-1">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="font-semibold text-gray-900">Transfer Bank</p>
                                            <p class="text-sm text-gray-500">BCA, Mandiri, BNI, BRI</p>
                                        </div>
                                        <i class="fas fa-university text-2xl text-[#B83556]"></i>
                                    </div>
                                </div>
                            </label>

                            <!-- E-Wallet -->
                            <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-[#B83556] transition-colors payment-option">
                                <input type="radio" 
                                       name="payment_method" 
                                       value="e_wallet" 
                                       class="w-5 h-5 text-[#B83556] focus:ring-[#B83556]"
                                       style="accent-color: #B83556;">
                                <div class="ml-4 flex-1">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="font-semibold text-gray-900">E-Wallet</p>
                                            <p class="text-sm text-gray-500">GoPay, OVO, DANA, ShopeePay</p>
                                        </div>
                                        <i class="fas fa-wallet text-2xl text-[#B83556]"></i>
                                    </div>
                                </div>
                            </label>

                            <!-- COD -->
                            <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-[#B83556] transition-colors payment-option">
                                <input type="radio" 
                                       name="payment_method" 
                                       value="cod" 
                                       class="w-5 h-5 text-[#B83556] focus:ring-[#B83556]"
                                       style="accent-color: #B83556;">
                                <div class="ml-4 flex-1">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="font-semibold text-gray-900">Bayar di Tempat (COD)</p>
                                            <p class="text-sm text-gray-500">Bayar saat barang tiba</p>
                                        </div>
                                        <i class="fas fa-hand-holding-usd text-2xl text-[#B83556]"></i>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>

                </div>

                <!-- Right Column - Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-md p-6 sticky top-8">
                        <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-receipt mr-2" style="color: #B83556;"></i>
                            Ringkasan Pesanan
                        </h2>

                        <!-- Products List -->
                        <div class="space-y-4 mb-6 max-h-96 overflow-y-auto">
                            @if(isset($items) && $items->count() > 0)
                                @foreach($items as $item)
                                <div class="flex items-start space-x-3 pb-4 border-b">
                                    <img src="{{ $item->product->image ? asset('storage/' . $item->product->image) : 'https://via.placeholder.com/60' }}" 
                                         alt="{{ $item->product->name }}"
                                         class="w-16 h-16 object-cover rounded-lg">
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-gray-900 truncate">{{ $item->product->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $item->product->category->name }}</p>
                                        <div class="flex items-center justify-between mt-1">
                                            <p class="text-sm text-gray-600">{{ $item->qty }} × Rp {{ number_format($item->product->price, 0, ',', '.') }}</p>
                                            <p class="text-sm font-bold" style="color: #B83556;">
                                                Rp {{ number_format($item->product->price * $item->qty, 0, ',', '.') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <p class="text-gray-500 text-center py-4">Tidak ada produk</p>
                            @endif
                        </div>

                        <!-- Price Summary -->
                        <div class="space-y-3 pt-4 border-t">
                            <div class="flex justify-between text-gray-600">
                                <span>Subtotal ({{ $totalItems ?? 0 }} produk)</span>
                                <span>Rp {{ number_format($subtotal ?? 0, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Biaya Pengiriman</span>
                                <span class="text-green-600 font-medium">GRATIS</span>
                            </div>
                            <div class="flex justify-between text-lg font-bold text-gray-900 pt-3 border-t">
                                <span>Total</span>
                                <span style="color: #B83556;">Rp {{ number_format($total ?? 0, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <!-- Checkout Button -->
                        <button type="submit" 
                                class="w-full mt-6 text-white py-3 px-4 rounded-lg font-semibold hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-[#B83556] focus:ring-offset-2 transition-all"
                                style="background-color: #B83556;">
                            <i class="fas fa-check-circle mr-2"></i>Buat Pesanan
                        </button>

                        <a href="{{ route('cart.index') }}" 
                           class="block w-full mt-3 text-center text-[#B83556] py-3 px-4 rounded-lg font-semibold border-2 border-[#B83556] hover:bg-[#F9CDD5] transition-colors">
                            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Keranjang
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Payment option selection styling
    const paymentOptions = document.querySelectorAll('.payment-option');
    const radioButtons = document.querySelectorAll('input[name="payment_method"]');
    
    radioButtons.forEach(radio => {
        radio.addEventListener('change', function() {
            paymentOptions.forEach(option => {
                option.classList.remove('border-[#B83556]', 'bg-pink-50');
                option.classList.add('border-gray-200');
            });
            
            if (this.checked) {
                this.closest('.payment-option').classList.remove('border-gray-200');
                this.closest('.payment-option').classList.add('border-[#B83556]', 'bg-pink-50');
            }
        });
        
        // Initialize first selected option
        if (radio.checked) {
            radio.closest('.payment-option').classList.add('border-[#B83556]', 'bg-pink-50');
        }
    });

    // Form validation
    const form = document.getElementById('checkout-form');
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Show loading state
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';
        
        // Submit form after a brief delay
        setTimeout(() => {
            form.submit();
        }, 500);
    });

    // Phone number validation
    const phoneInput = document.getElementById('phone');
    phoneInput.addEventListener('input', function(e) {
        // Remove non-numeric characters
        this.value = this.value.replace(/\D/g, '');
        
        // Limit to 15 characters
        if (this.value.length > 15) {
            this.value = this.value.slice(0, 15);
        }
    });

    // Postal code validation
    const postalCodeInput = document.getElementById('postal_code');
    postalCodeInput.addEventListener('input', function(e) {
        // Remove non-numeric characters
        this.value = this.value.replace(/\D/g, '');
        
        // Limit to 5 characters
        if (this.value.length > 5) {
            this.value = this.value.slice(0, 5);
        }
    });
});
</script>
@endpush
