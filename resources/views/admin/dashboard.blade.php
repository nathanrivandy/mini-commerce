@extends('admin.layout')

@section('title', 'Dashboard Admin - RILOKA')
@section('page-title', 'Dashboard')

@section('page-description')
<p class="mt-2 text-lg text-gray-600">Selamat datang kembali! Berikut ringkasan toko online Anda hari ini.</p>
@endsection

@section('page-actions')
<div class="flex flex-col sm:flex-row gap-3">
    <a href="{{ route('home') }}" class="inline-flex items-center justify-center rounded-xl bg-white px-6 py-3 text-sm font-semibold text-gray-700 shadow-lg ring-1 ring-gray-200 hover:bg-gray-50 hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
        <i class="fas fa-external-link-alt -ml-0.5 mr-2 h-4 w-4"></i>
        Lihat Website
    </a>
</div>
@endsection

@section('content')
<!-- Statistics Cards -->
<div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-8">
    <!-- Total Products -->
    <a href="{{ route('admin.products.index') }}" class="block bg-white overflow-hidden shadow-lg rounded-xl border border-gray-100 hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 cursor-pointer">
        <div class="p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-box text-white text-xl"></i>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Produk</dt>
                        <dd class="text-3xl font-bold text-gray-900 mt-1">{{ number_format($stats['total_products']) }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </a>

    <!-- Total Orders -->
    <a href="{{ route('admin.orders.index') }}" class="block bg-white overflow-hidden shadow-lg rounded-xl border border-gray-100 hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 cursor-pointer">
        <div class="p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-shopping-cart text-white text-xl"></i>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Pesanan</dt>
                        <dd class="text-3xl font-bold text-gray-900 mt-1">{{ number_format($stats['total_orders']) }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </a>

    <!-- Total Revenue -->
    <a href="{{ route('admin.orders.index') }}?status=delivered" class="block bg-white overflow-hidden shadow-lg rounded-xl border border-gray-100 hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 cursor-pointer">
        <div class="p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-money-bill-wave text-white text-xl"></i>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Pendapatan</dt>
                        <dd class="text-3xl font-bold text-gray-900 mt-1">
                            @php
                                $totalRevenue = $stats['total_revenue'];
                                if ($totalRevenue >= 1000000000) {
                                    echo 'Rp ' . number_format($totalRevenue / 1000000000, 1, ',', '.') . 'M';
                                } elseif ($totalRevenue >= 1000000) {
                                    echo 'Rp ' . number_format($totalRevenue / 1000000, 1, ',', '.') . 'jt';
                                } elseif ($totalRevenue >= 1000) {
                                    echo 'Rp ' . number_format($totalRevenue / 1000, 1, ',', '.') . 'rb';
                                } else {
                                    echo 'Rp ' . number_format($totalRevenue, 0, ',', '.');
                                }
                            @endphp
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </a>

    <!-- Total Customers -->
    <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-100 hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 cursor-pointer">
        <div class="p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-users text-white text-xl"></i>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Pelanggan</dt>
                        <dd class="text-3xl font-bold text-gray-900 mt-1">{{ number_format($stats['total_users']) }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions Section -->
<div class="bg-white shadow-lg rounded-xl border border-gray-100 mb-8 overflow-hidden">
    <div class="px-8 py-6 bg-gray-50 border-b border-gray-200">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center mr-4 shadow-md">
                <i class="fas fa-bolt text-white text-xl"></i>
            </div>
            <div>
                <h3 class="text-xl font-bold text-gray-900">Aksi Cepat</h3>
                <p class="mt-1 text-sm text-gray-600">Kelola toko Anda dengan mudah dan efisien</p>
            </div>
        </div>
    </div>
    <div class="p-8">
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
            <!-- Add Product -->
            <a href="{{ route('admin.products.create') }}" class="group relative bg-blue-600 p-6 rounded-xl border-2 border-blue-600 hover:bg-blue-700 hover:border-blue-700 hover:shadow-lg transform hover:-translate-y-1 transition-all duration-300 text-white">
                <div class="text-white mb-4">
                    <div class="w-12 h-12 bg-blue-500 bg-opacity-30 rounded-xl flex items-center justify-center group-hover:bg-opacity-40 transition-colors">
                        <i class="fas fa-plus text-xl"></i>
                    </div>
                </div>
                <h4 class="text-lg font-bold text-white mb-2">Tambah Produk</h4>
                <p class="text-sm text-blue-100">Tambahkan produk baru ke katalog</p>
            </a>

            <!-- Pending Orders -->
            <a href="{{ route('admin.orders.index') }}?status=pending" class="group relative bg-orange-600 p-6 rounded-xl border-2 border-orange-600 hover:bg-orange-700 hover:border-orange-700 hover:shadow-lg transform hover:-translate-y-1 transition-all duration-300 text-white">
                <div class="text-white mb-4">
                    <div class="w-12 h-12 bg-orange-500 bg-opacity-30 rounded-xl flex items-center justify-center group-hover:bg-opacity-40 transition-colors">
                        <i class="fas fa-clock text-xl"></i>
                    </div>
                </div>
                <h4 class="text-lg font-bold text-white mb-2">Pesanan Menunggu</h4>
                <p class="text-sm text-orange-100">{{ $stats['pending_orders'] }} menunggu proses</p>
            </a>

            <!-- Low Stock -->
            <a href="{{ route('admin.products.index') }}?stock=low" class="group relative bg-red-600 p-6 rounded-xl border-2 border-red-600 hover:bg-red-700 hover:border-red-700 hover:shadow-lg transform hover:-translate-y-1 transition-all duration-300 text-white">
                <div class="text-white mb-4">
                    <div class="w-12 h-12 bg-red-500 bg-opacity-30 rounded-xl flex items-center justify-center group-hover:bg-opacity-40 transition-colors">
                        <i class="fas fa-exclamation-triangle text-xl"></i>
                    </div>
                </div>
                <h4 class="text-lg font-bold text-white mb-2">Stok Rendah</h4>
                <p class="text-sm text-red-100">{{ $stats['low_stock_products'] }} produk perlu diisi</p>
            </a>

            <!-- Today Revenue -->
            <div class="relative bg-emerald-600 p-6 rounded-xl border-2 border-emerald-600 cursor-default text-white">
                <div class="text-white mb-4">
                    <div class="w-12 h-12 bg-emerald-500 bg-opacity-30 rounded-xl flex items-center justify-center">
                        <i class="fas fa-chart-line text-xl"></i>
                    </div>
                </div>
                <h4 class="text-lg font-bold text-white mb-2">Pendapatan Hari Ini</h4>
                <p class="text-sm text-emerald-100">
                    @php
                        $todayRevenue = $stats['today_revenue'] ?? 0;
                        if ($todayRevenue >= 1000000) {
                            echo 'Rp ' . number_format($todayRevenue / 1000000, 1, ',', '.') . 'jt';
                        } elseif ($todayRevenue >= 1000) {
                            echo 'Rp ' . number_format($todayRevenue / 1000, 1, ',', '.') . 'rb';
                        } else {
                            echo 'Rp ' . number_format($todayRevenue, 0, ',', '.');
                        }
                    @endphp
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Content Grid -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Recent Orders -->
    <div class="bg-white shadow-lg rounded-xl border border-gray-100 overflow-hidden">
        <div class="px-8 py-6 bg-gray-50 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-emerald-600 rounded-xl flex items-center justify-center mr-4 shadow-md">
                            <i class="fas fa-shopping-cart text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Pesanan Terbaru</h3>
                            <p class="mt-1 text-sm text-gray-600">Daftar pesanan terbaru yang masuk</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white text-sm font-semibold rounded-lg hover:bg-emerald-700 transition-colors shadow-md">
                        <span>Lihat Semua</span>
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
        </div>
        <div class="p-8">
            @if($recentOrders->count() > 0)
                <div class="space-y-4">
                    @foreach($recentOrders as $order)
                    <a href="{{ route('admin.orders.show', $order) }}" class="block">
                        <div class="flex items-center justify-between p-6 bg-white rounded-xl border border-gray-200 hover:shadow-md hover:border-blue-300 transition-all duration-200 cursor-pointer">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-gradient-to-br from-blue-100 to-blue-200 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-receipt text-blue-600 text-xl"></i>
                                </div>
                                <div>
                                    <p class="text-lg font-semibold text-gray-900">Order #{{ $order->id }}</p>
                                    <p class="text-sm text-gray-600">{{ $order->user->name }}</p>
                                    <p class="text-xs text-gray-400 bg-gray-100 px-2 py-1 rounded-full inline-block">{{ $order->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-bold text-gray-900">
                                    @php
                                        $orderTotal = $order->total;
                                        if ($orderTotal >= 1000000) {
                                            echo 'Rp ' . number_format($orderTotal / 1000000, 1, ',', '.') . 'jt';
                                        } elseif ($orderTotal >= 1000) {
                                            echo 'Rp ' . number_format($orderTotal / 1000, 1, ',', '.') . 'rb';
                                        } else {
                                            echo 'Rp ' . number_format($orderTotal, 0, ',', '.');
                                        }
                                    @endphp
                                </p>
                                <div class="mt-1">
                                    <span class="inline-block px-2 py-1 text-xs font-medium rounded-full
                                        @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                        @elseif($order->status === 'shipped') bg-purple-100 text-purple-800
                                        @elseif($order->status === 'delivered') bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <div class="mx-auto h-24 w-24 text-gray-300 mb-6 flex items-center justify-center">
                        <i class="fas fa-inbox text-6xl"></i>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-3">Belum ada pesanan</h4>
                    <p class="text-gray-500 mb-6 max-w-sm mx-auto">Mulai promosikan produk untuk mendapatkan pesanan pertama</p>
                    <a href="{{ route('admin.products.create') }}" class="inline-flex items-center px-6 py-3 border border-transparent rounded-xl shadow-lg text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 transform hover:-translate-y-0.5 transition-all">
                        <i class="fas fa-plus -ml-1 mr-2 h-4 w-4"></i>
                        Tambah Produk
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Product Overview -->
    <div class="bg-white shadow-lg rounded-xl border border-gray-100 overflow-hidden">
        <div class="px-8 py-6 bg-gray-50 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center mr-4 shadow-md">
                        <i class="fas fa-box text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Ringkasan Produk</h3>
                        <p class="mt-1 text-sm text-gray-600">Informasi produk dan stok toko</p>
                    </div>
                </div>
                <a href="{{ route('admin.products.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition-colors shadow-md">
                    <span>Kelola Produk</span>
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
        <div class="p-8">
            <div class="grid grid-cols-2 gap-6 mb-8">
                <div class="text-center p-6 bg-emerald-600 rounded-xl border border-emerald-600 text-white">
                    <div class="w-12 h-12 bg-emerald-500 bg-opacity-30 rounded-xl flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-check-circle text-white text-xl"></i>
                    </div>
                    <p class="text-sm font-semibold text-emerald-100 mb-2">Produk Aktif</p>
                    <p class="text-3xl font-bold text-white">{{ $stats['active_products'] ?? 0 }}</p>
                </div>
                <div class="text-center p-6 bg-red-600 rounded-xl border border-red-600 text-white">
                    <div class="w-12 h-12 bg-red-500 bg-opacity-30 rounded-xl flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-exclamation-triangle text-white text-xl"></i>
                    </div>
                    <p class="text-sm font-semibold text-red-100 mb-2">Stok Rendah</p>
                    <p class="text-3xl font-bold text-white">{{ $stats['low_stock_products'] }}</p>
                </div>
            </div>
            
            @if($bestSellingProducts->count() > 0)
                <div>
                    <h4 class="text-lg font-bold text-gray-900 mb-6 flex items-center">
                        <div class="w-10 h-10 bg-yellow-500 rounded-xl flex items-center justify-center mr-4 shadow-md">
                            <i class="fas fa-trophy text-white text-xl"></i>
                        </div>
                        Produk Terlaris
                    </h4>
                    <div class="space-y-4">
                        @foreach($bestSellingProducts->take(3) as $product)
                        <a href="{{ route('admin.products.show', $product) }}" class="block">
                            <div class="flex items-center space-x-4 p-4 bg-white rounded-xl border border-gray-200 hover:shadow-md hover:border-blue-300 transition-all duration-200 cursor-pointer">
                                <img class="h-16 w-16 rounded-xl object-cover shadow-md" 
                                     src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/64x64?text=P' }}" 
                                     alt="{{ $product->name }}">
                                <div class="flex-1 min-w-0">
                                    <p class="text-lg font-semibold text-gray-900 truncate">{{ $product->name }}</p>
                                    <p class="text-sm text-gray-500 bg-gray-100 px-2 py-1 rounded-full inline-block">
                                        <i class="fas fa-chart-bar mr-1"></i>{{ number_format($product->total_sold ?? 0) }} terjual
                                    </p>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="text-center py-12">
                    <div class="mx-auto h-24 w-24 text-gray-300 mb-6 flex items-center justify-center">
                        <i class="fas fa-box-open text-6xl"></i>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-3">Belum ada produk</h4>
                    <p class="text-gray-500 mb-6 max-w-sm mx-auto">Mulai dengan menambahkan produk pertama</p>
                    <a href="{{ route('admin.products.create') }}" class="inline-flex items-center px-6 py-3 border border-transparent rounded-xl shadow-lg text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 transform hover:-translate-y-0.5 transition-all">
                        <i class="fas fa-plus -ml-1 mr-2 h-4 w-4"></i>
                        Tambah Produk
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection