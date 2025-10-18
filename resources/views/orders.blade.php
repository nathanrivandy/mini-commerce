@extends('app')

@section('title', 'Pesanan Saya - Mini Commerce')

@section('content')
<div class="min-h-screen" style="background-color: #F9CDD5;">
    <!-- Header Section -->
    <div class="shadow-sm border-b" style="background: linear-gradient(to right, #B83556, #FF9CBF);">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-8">
                    <a href="{{ route('home') }}" 
                       class="text-white hover:text-gray-100 transition-colors flex items-center gap-2 bg-white/20 px-4 py-2 rounded-lg hover:bg-white/30">
                        <i class="fas fa-arrow-left"></i>
                        <span class="hidden sm:inline">Kembali ke Beranda</span>
                    </a>
                    <div>
                        <h1 class="text-3xl font-bold text-white">
                            <i class="fas fa-shopping-bag mr-3"></i>Pesanan Saya
                        </h1>
                        <p class="mt-2 text-white">Kelola dan lacak semua pesanan Anda</p>
                    </div>
                </div>
                <div class="text-right">
                    <span class="text-sm text-white">Total {{ $orders->total() }} pesanan</span>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Status Filter Tabs -->
        <div class="bg-white rounded-lg shadow-sm mb-6 overflow-hidden">
            <div class="flex flex-wrap border-b">
                <a href="{{ route('orders.index') }}" 
                   class="px-6 py-4 text-center flex-1 min-w-[120px] font-medium transition-all {{ !request('status') ? 'text-white' : 'text-gray-600 hover:bg-gray-50' }}"
                   style="{{ !request('status') ? 'background-color: #B83556;' : '' }}">
                    <i class="fas fa-list mr-2"></i>Semua
                    <span class="ml-2 px-2 py-1 rounded-full text-xs {{ !request('status') ? 'bg-white text-pink-600' : 'bg-gray-200' }}">
                        {{ $orders->total() }}
                    </span>
                </a>
                <a href="{{ route('orders.index', ['status' => 'processing']) }}" 
                   class="px-6 py-4 text-center flex-1 min-w-[120px] font-medium transition-all {{ request('status') == 'processing' ? 'text-white' : 'text-gray-600 hover:bg-gray-50' }}"
                   style="{{ request('status') == 'processing' ? 'background-color: #7A8450;' : '' }}">
                    <i class="fas fa-box mr-2"></i>Diproses
                </a>
                <a href="{{ route('orders.index', ['status' => 'shipped']) }}" 
                   class="px-6 py-4 text-center flex-1 min-w-[120px] font-medium transition-all {{ request('status') == 'shipped' ? 'text-white' : 'text-gray-600 hover:bg-gray-50' }}"
                   style="{{ request('status') == 'shipped' ? 'background-color: #FF9CBF;' : '' }}">
                    <i class="fas fa-truck mr-2"></i>Dikirim
                </a>
                <a href="{{ route('orders.index', ['status' => 'delivered']) }}" 
                   class="px-6 py-4 text-center flex-1 min-w-[120px] font-medium transition-all {{ request('status') == 'delivered' ? 'text-white' : 'text-gray-600 hover:bg-gray-50' }}"
                   style="{{ request('status') == 'delivered' ? 'background-color: #10B981;' : '' }}">
                    <i class="fas fa-check-circle mr-2"></i>Selesai
                </a>
                <a href="{{ route('orders.index', ['status' => 'cancelled']) }}" 
                   class="px-6 py-4 text-center flex-1 min-w-[120px] font-medium transition-all {{ request('status') == 'cancelled' ? 'text-white' : 'text-gray-600 hover:bg-gray-50' }}"
                   style="{{ request('status') == 'cancelled' ? 'background-color: #EF4444;' : '' }}">
                    <i class="fas fa-times-circle mr-2"></i>Dibatalkan
                </a>
            </div>
        </div>

        @if(session('success'))
        <div class="mb-6 p-4 rounded-lg text-white flex items-center" style="background-color: #10B981;">
            <i class="fas fa-check-circle mr-3 text-xl"></i>
            <span>{{ session('success') }}</span>
        </div>
        @endif

        @if(session('error'))
        <div class="mb-6 p-4 rounded-lg text-white flex items-center" style="background-color: #EF4444;">
            <i class="fas fa-exclamation-circle mr-3 text-xl"></i>
            <span>{{ session('error') }}</span>
        </div>
        @endif

        @if($orders->count() > 0)
        <!-- Orders List -->
        <div class="space-y-4">
            @foreach($orders as $order)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                <!-- Order Header -->
                <div class="px-6 py-4 border-b flex flex-wrap items-center justify-between gap-4" style="background-color: #FFF;">
                    <div class="flex items-center gap-6">
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Nomor Pesanan</p>
                            <p class="font-bold text-gray-900">{{ $order->order_number }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Tanggal Pesanan</p>
                            <p class="text-sm text-gray-700">
                                <i class="fas fa-calendar mr-1"></i>
                                {{ $order->created_at->format('d M Y') }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Metode Pembayaran</p>
                            <p class="text-sm font-medium text-gray-700">
                                @if($order->payment_method === 'cod')
                                    <i class="fas fa-money-bill-wave mr-1"></i>COD (Bayar di Tempat)
                                @elseif($order->payment_method === 'bank_transfer')
                                    <i class="fas fa-university mr-1"></i>Transfer Bank
                                @elseif($order->payment_method === 'e_wallet')
                                    <i class="fas fa-wallet mr-1"></i>E-Wallet
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="flex flex-col items-end gap-2">
                        @php
                            // Determine label for processing status based on payment method
                            $processingLabel = 'Dikemas';
                            $processingColor = '#7A8450';
                            $processingIcon = 'fa-box';
                            
                            if ($order->status === 'processing' && in_array($order->payment_method, ['bank_transfer', 'e_wallet'])) {
                                $processingLabel = 'Menunggu Konfirmasi';
                                $processingColor = '#F9C74F';
                                $processingIcon = 'fa-clock';
                            }
                            
                            $statusConfig = [
                                'pending' => ['color' => '#F9C74F', 'icon' => 'fa-clock', 'label' => 'Menunggu Konfirmasi'],
                                'processing' => ['color' => $processingColor, 'icon' => $processingIcon, 'label' => $processingLabel],
                                'shipped' => ['color' => '#FF9CBF', 'icon' => 'fa-truck', 'label' => 'Dikirim'],
                                'delivered' => ['color' => '#10B981', 'icon' => 'fa-check-circle', 'label' => 'Selesai'],
                                'cancelled' => ['color' => '#EF4444', 'icon' => 'fa-times-circle', 'label' => 'Dibatalkan'],
                            ];
                            $config = $statusConfig[$order->status] ?? ['color' => '#6B7280', 'icon' => 'fa-question', 'label' => 'Unknown'];
                        @endphp
                        <span class="px-4 py-2 rounded-full text-white font-medium text-sm" 
                              style="background-color: {{ $config['color'] }};">
                            <i class="fas {{ $config['icon'] }} mr-2"></i>{{ $config['label'] }}
                        </span>
                        @if($order->status === 'processing' && in_array($order->payment_method, ['bank_transfer', 'e_wallet']))
                        <p class="text-xs text-gray-600 italic">
                            <i class="fas fa-info-circle mr-1"></i>Menunggu admin mengkonfirmasi pembayaran
                        </p>
                        @endif
                    </div>
                </div>

                <!-- Order Items -->
                <div class="px-6 py-4">
                    <div class="space-y-3">
                        @foreach($order->items as $item)
                        <div class="flex items-center gap-4 py-2">
                            <div class="w-16 h-16 flex-shrink-0 rounded-lg overflow-hidden border">
                                @if($item->product && $item->product->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}" 
                                         alt="{{ $item->product_name }}"
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                                        <i class="fas fa-image text-gray-300 text-xl"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <h4 class="font-medium text-gray-900">{{ $item->product_name }}</h4>
                                <p class="text-sm text-gray-500">{{ $item->qty }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold" style="color: #B83556;">
                                    Rp {{ number_format($item->price * $item->qty, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Order Footer -->
                <div class="px-6 py-4 border-t flex flex-wrap items-center justify-between gap-4" style="background-color: #F9FAFB;">
                    <div class="flex items-center gap-6">
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Total Pesanan</p>
                            <p class="text-xl font-bold" style="color: #B83556;">
                                Rp {{ number_format($order->total, 0, ',', '.') }}
                            </p>
                        </div>
                        @if($order->items->count() > 1)
                        <div>
                            <p class="text-xs text-gray-500">{{ $order->items->count() }} produk</p>
                        </div>
                        @endif
                    </div>
                    <div class="flex items-center gap-3">
                        <button onclick="toggleOrderDetail('order-{{ $order->id }}')"
                                class="px-4 py-2 rounded-lg font-medium transition-all hover:opacity-90"
                                style="background-color: #F9CDD5; color: #B83556;">
                            <i class="fas fa-info-circle mr-2"></i>Lihat Detail
                        </button>
                        @if($order->canBeCancelled())
                        <form id="cancel-form-{{ $order->id }}" action="{{ route('orders.cancel', $order->id) }}" method="POST" class="inline" style="display: none;">
                            @csrf
                            @method('PATCH')
                        </form>
                        <button type="button" 
                                onclick="cancelOrder({{ $order->id }})"
                                class="px-4 py-2 rounded-lg font-medium text-white transition-all hover:opacity-90"
                                style="background-color: #EF4444;">
                            <i class="fas fa-times mr-2"></i>Batalkan
                        </button>
                        @endif
                    </div>
                </div>

                <!-- Order Detail (Hidden by default) -->
                <div id="order-{{ $order->id }}" class="hidden border-t" style="background-color: #FFFBF5;">
                    <div class="px-6 py-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">
                            <i class="fas fa-file-invoice mr-2"></i>Detail Pesanan
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Shipping Info -->
                            <div class="bg-white rounded-lg p-4 border">
                                <h4 class="font-semibold text-gray-900 mb-3 flex items-center">
                                    <i class="fas fa-map-marker-alt mr-2" style="color: #B83556;"></i>
                                    Alamat Pengiriman
                                </h4>
                                <p class="text-gray-700 whitespace-pre-line">{{ $order->address_text }}</p>
                                <div class="mt-3 pt-3 border-t">
                                    <p class="text-sm text-gray-600">
                                        <i class="fas fa-phone mr-2"></i>
                                        <span class="font-medium">{{ $order->phone }}</span>
                                    </p>
                                </div>
                            </div>

                            <!-- Order Summary -->
                            <div class="bg-white rounded-lg p-4 border">
                                <h4 class="font-semibold text-gray-900 mb-3 flex items-center">
                                    <i class="fas fa-receipt mr-2" style="color: #B83556;"></i>
                                    Ringkasan Pesanan
                                </h4>
                                <div class="space-y-2">
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Subtotal Produk</span>
                                        <span class="font-medium">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Ongkos Kirim</span>
                                        <span class="font-medium text-green-600">Gratis</span>
                                    </div>
                                    <div class="pt-2 border-t">
                                        <div class="flex justify-between">
                                            <span class="font-semibold text-gray-900">Total Pembayaran</span>
                                            <span class="font-bold text-xl" style="color: #B83556;">
                                                Rp {{ number_format($order->total, 0, ',', '.') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Notes -->
                            @if($order->notes)
                            <div class="bg-white rounded-lg p-4 border md:col-span-2">
                                <h4 class="font-semibold text-gray-900 mb-3 flex items-center">
                                    <i class="fas fa-sticky-note mr-2" style="color: #B83556;"></i>
                                    Catatan
                                </h4>
                                <p class="text-gray-700">{{ $order->notes }}</p>
                            </div>
                            @endif

                            <!-- Order Timeline -->
                            <div class="bg-white rounded-lg p-4 border md:col-span-2">
                                <h4 class="font-semibold text-gray-900 mb-4 flex items-center">
                                    <i class="fas fa-history mr-2" style="color: #B83556;"></i>
                                    Riwayat Pesanan
                                </h4>
                                <div class="relative">
                                    <div class="absolute left-4 top-0 bottom-0 w-0.5" style="background-color: #F9CDD5;"></div>
                                    
                                    <div class="space-y-4">
                                        <!-- Pesanan Dibuat -->
                                        <div class="relative pl-10">
                                            <div class="absolute left-0 w-8 h-8 rounded-full flex items-center justify-center text-white"
                                                 style="background-color: #B83556;">
                                                <i class="fas fa-shopping-cart text-sm"></i>
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-900">Pesanan Dibuat</p>
                                                <p class="text-sm text-gray-500">{{ $order->created_at->format('d M Y, H:i') }}</p>
                                            </div>
                                        </div>

                                        <!-- Processing (Menunggu Konfirmasi atau Dikemas) -->
                                        <div class="relative pl-10">
                                            @php
                                                $isActive = in_array($order->status, ['processing', 'shipped', 'delivered']);
                                                $processingBgColor = $isActive ? '#7A8450' : '#D1D5DB';
                                                
                                                // Show different label based on payment method
                                                if ($order->payment_method === 'cod') {
                                                    $processingLabel = 'Pesanan Dikemas';
                                                } else {
                                                    $processingLabel = 'Menunggu Konfirmasi Pembayaran';
                                                }
                                            @endphp
                                            <div class="absolute left-0 w-8 h-8 rounded-full flex items-center justify-center text-white"
                                                 style="background-color: {{ $processingBgColor }};">
                                                <i class="fas {{ $order->payment_method === 'cod' ? 'fa-box' : 'fa-clock' }} text-sm"></i>
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-900">{{ $processingLabel }}</p>
                                                <p class="text-sm text-gray-500">
                                                    @if($isActive)
                                                        {{ $order->updated_at->format('d M Y, H:i') }}
                                                    @else
                                                        Menunggu
                                                    @endif
                                                </p>
                                            </div>
                                        </div>

                                        @if(in_array($order->status, ['shipped', 'delivered']))
                                        <!-- Dikirim -->
                                        <div class="relative pl-10">
                                            <div class="absolute left-0 w-8 h-8 rounded-full flex items-center justify-center text-white"
                                                 style="background-color: #FF9CBF;">
                                                <i class="fas fa-truck text-sm"></i>
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-900">Pesanan Dikirim</p>
                                                <p class="text-sm text-gray-500">{{ $order->updated_at->format('d M Y, H:i') }}</p>
                                            </div>
                                        </div>
                                        @endif

                                        @if($order->status == 'delivered')
                                        <!-- Selesai -->
                                        <div class="relative pl-10">
                                            <div class="absolute left-0 w-8 h-8 rounded-full flex items-center justify-center text-white"
                                                 style="background-color: #10B981;">
                                                <i class="fas fa-check-circle text-sm"></i>
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-900">Pesanan Selesai</p>
                                                <p class="text-sm text-gray-500">{{ $order->updated_at->format('d M Y, H:i') }}</p>
                                            </div>
                                        </div>
                                        @endif

                                        @if($order->status == 'cancelled')
                                        <!-- Dibatalkan -->
                                        <div class="relative pl-10">
                                            <div class="absolute left-0 w-8 h-8 rounded-full flex items-center justify-center text-white"
                                                 style="background-color: #EF4444;">
                                                <i class="fas fa-times-circle text-sm"></i>
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-900">Pesanan Dibatalkan</p>
                                                <p class="text-sm text-gray-500">{{ $order->updated_at->format('d M Y, H:i') }}</p>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $orders->links() }}
        </div>
        @else
        <!-- Empty State -->
        <div class="bg-white rounded-xl shadow-md p-12 text-center">
            <div class="mb-6">
                <i class="fas fa-shopping-bag text-gray-300 text-6xl"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 mb-2">
                @if(request('status'))
                    Tidak Ada Pesanan dengan Status Ini
                @else
                    Belum Ada Pesanan
                @endif
            </h2>
            <p class="text-gray-600 mb-6">
                @if(request('status'))
                    Anda belum memiliki pesanan dengan status {{ request('status') }}
                @else
                    Anda belum melakukan pemesanan apapun
                @endif
            </p>
            <a href="{{ route('products.index') }}" 
               class="inline-block text-white px-8 py-3 rounded-lg font-semibold transition-colors"
               style="background-color: #B83556;">
                <i class="fas fa-shopping-cart mr-2"></i>
                Mulai Belanja
            </a>
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <p class="text-lg font-medium text-gray-900 mb-6">${message}</p>
            <div class="flex gap-3">
                <button class="cancel-btn flex-1 px-4 py-2 rounded-lg font-medium transition-all duration-200 hover:opacity-90" 
                        style="background-color: #F9CDD5; color: #B83556;">
                    Kembali
                </button>
                <button class="confirm-btn flex-1 px-4 py-2 rounded-lg font-medium text-white transition-all duration-200 hover:opacity-90" 
                        style="background-color: #B83556;">
                    Batalkan Pesanan
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

function toggleOrderDetail(orderId) {
    const element = document.getElementById(orderId);
    const isHidden = element.classList.contains('hidden');
    
    // Close all other details
    document.querySelectorAll('[id^="order-"]').forEach(el => {
        if (el.id !== orderId) {
            el.classList.add('hidden');
        }
    });
    
    // Toggle current detail
    if (isHidden) {
        element.classList.remove('hidden');
        // Smooth scroll to detail
        element.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    } else {
        element.classList.add('hidden');
    }
}

// Handle cancel order
function cancelOrder(orderId) {
    showCustomConfirm('Apakah Anda yakin ingin membatalkan pesanan ini?', () => {
        document.getElementById('cancel-form-' + orderId).submit();
    });
}
</script>
@endpush
