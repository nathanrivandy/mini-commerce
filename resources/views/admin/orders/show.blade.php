@extends('admin.layout')

@section('title', 'Detail Pesanan #' . $order->id . ' - Admin')
@section('page-title', 'Detail Pesanan #' . $order->id)

@section('page-description')
<p class="mt-2 text-sm text-gray-700">
    @if($order->order_number)
        {{ $order->order_number }} • 
    @endif
    {{ $order->created_at->format('d F Y, H:i') }}
</p>
@endsection

@section('page-actions')
<div class="flex items-center space-x-3">
    <!-- Status Update -->
    <div class="flex items-center">
        <label for="status-select" class="text-sm font-medium text-gray-700 mr-2">Status:</label>
        <select id="status-select" class="text-xs font-medium px-3 py-2 rounded border focus:ring-2 focus:ring-blue-500
            @if($order->status === 'pending') bg-yellow-100 text-yellow-800 border-yellow-300
            @elseif($order->status === 'processing') bg-blue-100 text-blue-800 border-blue-300
            @elseif($order->status === 'shipped') bg-purple-100 text-purple-800 border-purple-300
            @elseif($order->status === 'delivered') bg-green-100 text-green-800 border-green-300
            @elseif($order->status === 'cancelled') bg-red-100 text-red-800 border-red-300
            @endif" 
            data-order-id="{{ $order->id }}">
            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
            <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
            <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
            @if($order->canBeCancelled())
                <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            @endif
        </select>
    </div>
    
    <button type="button" onclick="goBack()" class="inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
        <i class="fas fa-arrow-left -ml-0.5 mr-1.5 h-4 w-4"></i>
        Kembali
    </button>
</div>
@endsection

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Order Items -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Items Pesanan</h3>
                    <p class="mt-1 text-sm text-gray-600">Daftar produk yang dipesan</p>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @foreach($order->items as $item)
                        <div class="flex items-center p-4 border border-gray-200 rounded-lg">
                            <div class="flex-shrink-0">
                                <img class="w-16 h-16 rounded-lg object-cover" 
                                     src="{{ $item->product && $item->product->image ? asset('storage/' . $item->product->image) : 'https://via.placeholder.com/64x64?text=No+Image' }}" 
                                     alt="{{ $item->product_name }}">
                            </div>
                            <div class="flex-1 ml-4">
                                <h4 class="text-sm font-medium text-gray-900">{{ $item->product_name }}</h4>
                                @if($item->product)
                                    <p class="text-sm text-gray-500">SKU: {{ $item->product->id }} • {{ $item->product->category->name ?? 'No Category' }}</p>
                                @endif
                                <div class="mt-1 flex items-center text-sm text-gray-500">
                                    <span>Qty: {{ $item->qty }}</span>
                                    <span class="mx-2">•</span>
                                    <span>Rp {{ number_format($item->price, 0, ',', '.') }} per item</span>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-gray-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Order Timeline -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Timeline Pesanan</h3>
                    <p class="mt-1 text-sm text-gray-600">Riwayat status pesanan</p>
                </div>
                <div class="p-6">
                    <div class="flow-root">
                        <ul class="space-y-0">
                            <li>
                                <div class="relative pb-8">
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-3 w-3 rounded-full bg-green-500 mt-2"></span>
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">Pesanan dibuat</p>
                                                <p class="text-sm text-gray-500">Pesanan berhasil dibuat oleh pelanggan</p>
                                            </div>
                                            <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                {{ $order->created_at->format('d M Y, H:i') }}
                                            </div>
                                        </div>
                                    </div>
                                    @if($order->status !== 'pending')
                                    <div class="absolute top-4 left-1.5 -ml-px h-full w-0.5 bg-gray-200"></div>
                                    @endif
                                </div>
                            </li>

                            @if($order->status !== 'pending')
                            <li>
                                <div class="relative pb-8">
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-3 w-3 rounded-full bg-blue-500 mt-2"></span>
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">Pesanan diproses</p>
                                                <p class="text-sm text-gray-500">Pesanan sedang diproses oleh admin</p>
                                            </div>
                                            <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                {{ $order->updated_at->format('d M Y, H:i') }}
                                            </div>
                                        </div>
                                    </div>
                                    @if(!in_array($order->status, ['processing', 'cancelled']))
                                    <div class="absolute top-4 left-1.5 -ml-px h-full w-0.5 bg-gray-200"></div>
                                    @endif
                                </div>
                            </li>
                            @endif

                            @if(in_array($order->status, ['shipped', 'delivered']))
                            <li>
                                <div class="relative pb-8">
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-3 w-3 rounded-full bg-purple-500 mt-2"></span>
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">Pesanan dikirim</p>
                                                <p class="text-sm text-gray-500">Pesanan sedang dalam perjalanan</p>
                                            </div>
                                            <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                {{ $order->updated_at->format('d M Y, H:i') }}
                                            </div>
                                        </div>
                                    </div>
                                    @if($order->status !== 'shipped')
                                    <div class="absolute top-4 left-1.5 -ml-px h-full w-0.5 bg-gray-200"></div>
                                    @endif
                                </div>
                            </li>
                            @endif

                            @if($order->status === 'delivered')
                            <li>
                                <div class="relative pb-4">
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-3 w-3 rounded-full bg-green-500 mt-2"></span>
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">Pesanan selesai</p>
                                                <p class="text-sm text-gray-500">Pesanan telah sampai ke pelanggan</p>
                                            </div>
                                            <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                {{ $order->updated_at->format('d M Y, H:i') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @endif

                            @if($order->status === 'cancelled')
                            <li>
                                <div class="relative pb-4">
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-3 w-3 rounded-full bg-red-500 mt-2"></span>
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">Pesanan dibatalkan</p>
                                                <p class="text-sm text-gray-500">Pesanan telah dibatalkan</p>
                                            </div>
                                            <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                {{ $order->updated_at->format('d M Y, H:i') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Customer Info -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Informasi Pelanggan</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                <span class="text-lg font-medium text-blue-600">{{ substr($order->user->name, 0, 1) }}</span>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $order->user->name }}</p>
                                <p class="text-sm text-gray-500">{{ $order->user->email }}</p>
                            </div>
                        </div>
                        
                        @if($order->phone)
                        <div class="flex items-start space-x-3">
                            <i class="fas fa-phone text-gray-400 mt-1"></i>
                            <div>
                                <p class="text-sm text-gray-500">Nomor Telepon</p>
                                <p class="text-sm font-medium text-gray-900">{{ $order->phone }}</p>
                            </div>
                        </div>
                        @endif

                        @if($order->address_text)
                        <div class="flex items-start space-x-3">
                            <i class="fas fa-map-marker-alt text-gray-400 mt-1"></i>
                            <div>
                                <p class="text-sm text-gray-500">Alamat Pengiriman</p>
                                <p class="text-sm text-gray-900">{{ $order->address_text }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Ringkasan Pesanan</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Subtotal ({{ $order->items->sum('qty') }} items)</span>
                            <span class="text-gray-900">Rp {{ number_format($order->items->sum('subtotal'), 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Ongkos Kirim</span>
                            <span class="text-gray-900">Gratis</span>
                        </div>
                        <div class="border-t border-gray-200 pt-3">
                            <div class="flex justify-between font-medium text-lg">
                                <span class="text-gray-900">Total</span>
                                <span class="text-blue-600">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Method -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Metode Pembayaran</h3>
                </div>
                <div class="p-6">
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 
                                @if($order->payment_method === 'bank_transfer') bg-blue-100
                                @elseif($order->payment_method === 'e_wallet') bg-purple-100
                                @else bg-green-100
                                @endif
                                rounded-lg flex items-center justify-center">
                                <i class="fas 
                                    @if($order->payment_method === 'bank_transfer') fa-university text-blue-600
                                    @elseif($order->payment_method === 'e_wallet') fa-wallet text-purple-600
                                    @else fa-money-bill-wave text-green-600
                                    @endif
                                    text-lg"></i>
                            </div>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">
                                @if($order->payment_method === 'bank_transfer')
                                    Transfer Bank
                                @elseif($order->payment_method === 'e_wallet')
                                    E-Wallet
                                @else
                                    Cash on Delivery (COD)
                                @endif
                            </p>
                            <p class="text-sm text-gray-500 mt-1">
                                @if($order->payment_method === 'bank_transfer')
                                    Pembayaran melalui transfer bank
                                @elseif($order->payment_method === 'e_wallet')
                                    Pembayaran melalui e-wallet
                                @else
                                    Bayar di tempat saat barang diterima
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Notes -->
            @if($order->notes)
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Catatan</h3>
                </div>
                <div class="p-6">
                    <p class="text-sm text-gray-700">{{ $order->notes }}</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Status change handler
    const statusSelect = document.getElementById('status-select');
    const originalStatus = statusSelect.value;

    statusSelect.addEventListener('change', function() {
        const orderId = this.dataset.orderId;
        const newStatus = this.value;

        if (confirm(`Apakah Anda yakin ingin mengubah status pesanan menjadi ${newStatus}?`)) {
            fetch(`/admin/orders/${orderId}/status`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ status: newStatus })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateStatusStyling(this, newStatus);
                    showNotification('Status pesanan berhasil diperbarui', 'success');
                    // Reload page to update timeline
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    this.value = originalStatus;
                    showNotification(data.message || 'Gagal mengubah status', 'error');
                }
            })
            .catch(error => {
                this.value = originalStatus;
                showNotification('Terjadi kesalahan', 'error');
            });
        } else {
            this.value = originalStatus;
        }
    });

    function updateStatusStyling(select, status) {
        // Remove all status classes
        const statusClasses = ['bg-yellow-100', 'text-yellow-800', 'border-yellow-300',
                              'bg-blue-100', 'text-blue-800', 'border-blue-300',
                              'bg-purple-100', 'text-purple-800', 'border-purple-300',
                              'bg-green-100', 'text-green-800', 'border-green-300',
                              'bg-red-100', 'text-red-800', 'border-red-300'];
        select.classList.remove(...statusClasses);

        // Add new status classes
        switch(status) {
            case 'pending':
                select.classList.add('bg-yellow-100', 'text-yellow-800', 'border-yellow-300');
                break;
            case 'processing':
                select.classList.add('bg-blue-100', 'text-blue-800', 'border-blue-300');
                break;
            case 'shipped':
                select.classList.add('bg-purple-100', 'text-purple-800', 'border-purple-300');
                break;
            case 'delivered':
                select.classList.add('bg-green-100', 'text-green-800', 'border-green-300');
                break;
            case 'cancelled':
                select.classList.add('bg-red-100', 'text-red-800', 'border-red-300');
                break;
        }
    }

    function showNotification(message, type = 'info') {
        const bgColor = type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : 'bg-blue-500';
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 ${bgColor} text-white px-6 py-3 rounded-lg shadow-lg z-50 transform translate-x-full transition-transform duration-300`;
        notification.textContent = message;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.classList.remove('translate-x-full');
        }, 100);
        
        setTimeout(() => {
            notification.classList.add('translate-x-full');
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 300);
        }, 3000);
    }

    // Global function for back button
    window.goBack = function() {
        window.history.back();
    }
});
</script>
@endpush