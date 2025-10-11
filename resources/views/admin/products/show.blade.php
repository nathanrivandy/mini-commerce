@extends('admin.layout')

@section('title', 'Detail Produk - Mini Commerce')
@section('page-title', 'Detail Produk')

@section('page-description')
<p class="mt-2 text-lg text-gray-600">Informasi lengkap produk "{{ $product->name }}".</p>
@endsection

@section('page-actions')
<div class="flex flex-col sm:flex-row gap-3">
    <a href="{{ route('admin.products.index') }}" class="inline-flex items-center justify-center rounded-xl bg-white px-6 py-3 text-sm font-semibold text-gray-700 shadow-lg ring-1 ring-gray-200 hover:bg-gray-50 hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
        <i class="fas fa-arrow-left -ml-0.5 mr-2 h-4 w-4"></i>
        Kembali
    </a>
</div>
@endsection

@section('content')
<!-- Product Information -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
    <!-- Product Image -->
    <div class="lg:col-span-1">
        <div class="bg-white shadow-lg rounded-xl border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h3 class="text-lg font-bold text-gray-900">Gambar Produk</h3>
            </div>
            <div class="p-6">
                <div class="aspect-w-1 aspect-h-1 mb-4">
                    <img class="w-full h-80 object-cover rounded-xl shadow-md" 
                         src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/400x400?text=No+Image' }}" 
                         alt="{{ $product->name }}">
                </div>
            </div>
        </div>
    </div>

    <!-- Product Details -->
    <div class="lg:col-span-2">
        <div class="bg-white shadow-lg rounded-xl border border-gray-100 overflow-hidden">
            <div class="px-8 py-6 bg-gray-50 border-b border-gray-200">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-primary-500 rounded-xl flex items-center justify-center mr-4 shadow-md">
                        <i class="fas fa-box text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">{{ $product->name }}</h3>
                        <p class="mt-1 text-sm text-gray-600">Slug: /{{ $product->slug }}</p>
                    </div>
                </div>
            </div>

            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Basic Information -->
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Nama Produk</label>
                            <p class="text-lg font-semibold text-gray-900">{{ $product->name }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Kategori</label>
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-primary-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-tag text-primary-600 text-sm"></i>
                                </div>
                                <span class="text-base text-gray-900">{{ $product->category->name }}</span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Harga</label>
                            <p class="text-2xl font-bold text-primary-600">{{ 'Rp ' . number_format($product->price, 0, ',', '.') }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Stok</label>
                            <div class="flex items-center">
                                <span class="text-lg font-semibold text-gray-900 mr-3">{{ number_format($product->stock) }}</span>
                                @if($product->stock < 10)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-danger-100 text-danger-800">
                                        <i class="fas fa-exclamation-triangle mr-1"></i>
                                        Stok Rendah
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Additional Information -->
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Status</label>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $product->is_active ? 'bg-secondary-100 text-secondary-800' : 'bg-danger-100 text-danger-800' }}">
                                <i class="fas {{ $product->is_active ? 'fa-check-circle' : 'fa-times-circle' }} mr-2"></i>
                                {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Dibuat</label>
                            <p class="text-base text-gray-900">{{ $product->created_at->format('d M Y H:i') }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Terakhir Diupdate</label>
                            <p class="text-base text-gray-900">{{ $product->updated_at->format('d M Y H:i') }}</p>
                        </div>

                        @if($product->orderItems->count() > 0)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Total Terjual</label>
                            <p class="text-lg font-semibold text-secondary-600">{{ number_format($product->orderItems->sum('qty')) }} unit</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Description -->
                <div class="mt-8 pt-8 border-t border-gray-200">
                    <label class="block text-sm font-medium text-gray-500 mb-3">Deskripsi Produk</label>
                    <div class="prose max-w-none">
                        <p class="text-gray-900 leading-relaxed">{{ $product->description ?: 'Tidak ada deskripsi untuk produk ini.' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">

    <!-- Sales -->
    <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-100">
        <div class="p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-secondary-500 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-shopping-cart text-white text-xl"></i>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Terjual</dt>
                        <dd class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($product->orderItems->sum('qty')) }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Revenue -->
    <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-100">
        <div class="p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-warning-500 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-money-bill-wave text-white text-xl"></i>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Revenue</dt>
                        <dd class="text-2xl font-bold text-gray-900 mt-1">
                            @php
                                $revenue = $product->orderItems->sum('subtotal');
                                if ($revenue >= 1000000) {
                                    echo 'Rp ' . number_format($revenue / 1000000, 1, ',', '.') . 'jt';
                                } elseif ($revenue >= 1000) {
                                    echo 'Rp ' . number_format($revenue / 1000, 1, ',', '.') . 'rb';
                                } else {
                                    echo 'Rp ' . number_format($revenue, 0, ',', '.');
                                }
                            @endphp
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Stock Status -->
    <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-100">
        <div class="p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 {{ $product->stock <= 10 ? 'bg-danger-500' : ($product->stock <= 50 ? 'bg-warning-500' : 'bg-secondary-500') }} rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas {{ $product->stock <= 10 ? 'fa-exclamation-triangle' : 'fa-box' }} text-white text-xl"></i>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Stok</dt>
                        <dd class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($product->stock) }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Actions -->
<div class="bg-white shadow-lg rounded-xl border border-gray-100 overflow-hidden">
    <div class="px-8 py-6 bg-gray-50 border-b border-gray-200">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-gray-600 rounded-xl flex items-center justify-center mr-4 shadow-md">
                <i class="fas fa-cogs text-white text-xl"></i>
            </div>
            <div>
                <h3 class="text-xl font-bold text-gray-900">Aksi Produk</h3>
                <p class="mt-1 text-sm text-gray-600">Kelola status dan data produk</p>
            </div>
        </div>
    </div>

    <div class="p-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Edit Product -->
            <a href="{{ route('admin.products.edit', $product) }}" class="group relative bg-primary-500 p-6 rounded-xl border-2 border-primary-500 hover:bg-primary-600 hover:border-primary-600 hover:shadow-lg transform hover:-translate-y-1 transition-all duration-300 text-white">
                <div class="text-center">
                    <div class="w-12 h-12 bg-primary-400 bg-opacity-30 rounded-xl flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-edit text-xl"></i>
                    </div>
                    <h4 class="text-lg font-bold mb-2">Edit Produk</h4>
                    <p class="text-sm text-primary-100">Ubah informasi produk</p>
                </div>
            </a>

            <!-- Delete Product -->
            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="group" onsubmit="return confirm('Yakin ingin menghapus produk ini? Aksi ini tidak dapat dibatalkan!')">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full bg-danger-500 hover:bg-danger-600 text-white p-6 rounded-xl border-2 border-danger-500 hover:border-danger-600 hover:shadow-lg transform hover:-translate-y-1 transition-all duration-300 {{ $product->orderItems->count() > 0 ? 'opacity-50 cursor-not-allowed' : '' }}" {{ $product->orderItems->count() > 0 ? 'disabled' : '' }}>
                    <div class="text-center">
                        <div class="w-12 h-12 bg-danger-400 bg-opacity-30 rounded-xl flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-trash text-xl"></i>
                        </div>
                        <h4 class="text-lg font-bold mb-2">Hapus Produk</h4>
                        <p class="text-sm text-danger-100">{{ $product->orderItems->count() > 0 ? 'Tidak dapat dihapus (ada pesanan)' : 'Hapus produk secara permanen' }}</p>
                    </div>
                </button>
            </form>
        </div>
    </div>
</div>
@endsection