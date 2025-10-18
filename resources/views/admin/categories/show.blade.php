@extends('admin.layout')

@section('title', 'Detail Kategori - Riloka')
@section('page-title', 'Detail Kategori')

@section('page-description')
<p class="mt-2 text-lg text-gray-600">Informasi lengkap kategori "{{ $category->name }}" dan produk-produknya.</p>
@endsection

@section('page-actions')
<div class="flex flex-col sm:flex-row gap-3">
    <a href="{{ route('admin.categories.edit', $category) }}" class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-lg hover:bg-blue-700 hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
        <i class="fas fa-edit -ml-0.5 mr-2 h-4 w-4"></i>
        Edit Kategori
    </a>
    <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center justify-center rounded-xl bg-white px-6 py-3 text-sm font-semibold text-gray-700 shadow-lg ring-1 ring-gray-200 hover:bg-gray-50 hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
        <i class="fas fa-arrow-left -ml-0.5 mr-2 h-4 w-4"></i>
        Kembali
    </a>
</div>
@endsection

@section('content')
<!-- Category Information -->
<div class="bg-white shadow-lg rounded-xl border border-gray-100 overflow-hidden mb-8">
    <div class="px-8 py-6 bg-gray-50 border-b border-gray-200">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center mr-4 shadow-md">
                <i class="fas fa-tag text-white text-xl"></i>
            </div>
            <div>
                <h3 class="text-xl font-bold text-gray-900">{{ $category->name }}</h3>
                <p class="mt-1 text-sm text-gray-600">Slug: /{{ $category->slug }}</p>
            </div>
        </div>
    </div>

    <div class="p-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Category Details -->
            <div>
                <h4 class="text-lg font-semibold text-gray-900 mb-4">Informasi Kategori</h4>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Nama</label>
                        <p class="text-base text-gray-900">{{ $category->name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Slug</label>
                        <p class="text-base text-gray-900 font-mono">{{ $category->slug }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Deskripsi</label>
                        <p class="text-base text-gray-900">{{ $category->description ?: 'Tidak ada deskripsi' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Dibuat</label>
                        <p class="text-base text-gray-900">{{ $category->created_at->format('d M Y H:i') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Terakhir Diupdate</label>
                        <p class="text-base text-gray-900">{{ $category->updated_at->format('d M Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            <div>
                <h4 class="text-lg font-semibold text-gray-900 mb-4">Statistik</h4>
                <div class="space-y-4">
                    <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-box text-white"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-blue-600">Total Produk</p>
                                <p class="text-2xl font-bold text-blue-900">{{ number_format($category->products_count) }}</p>
                            </div>
                        </div>
                    </div>
                    
                    @if($category->products_count > 0)
                    <div class="bg-emerald-50 rounded-lg p-4 border border-emerald-200">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-emerald-600 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-check-circle text-white"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-emerald-600">Produk Aktif</p>
                                <p class="text-2xl font-bold text-emerald-900">{{ number_format($category->products->where('is_active', true)->count()) }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Products in Category -->
<div class="bg-white shadow-lg rounded-xl border border-gray-100 overflow-hidden">
    <div class="px-8 py-6 bg-gray-50 border-b border-gray-200">
        <div class="flex justify-between items-center">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-emerald-600 rounded-xl flex items-center justify-center mr-4 shadow-md">
                    <i class="fas fa-list text-white text-xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Produk dalam Kategori</h3>
                    <p class="mt-1 text-sm text-gray-600">{{ number_format($category->products_count) }} produk total</p>
                </div>
            </div>
            <a href="{{ route('admin.products.create') }}?category={{ $category->slug }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white text-sm font-semibold rounded-lg hover:bg-emerald-700 transition-colors shadow-md">
                <span>Tambah Produk</span>
                <i class="fas fa-plus ml-2"></i>
            </a>
        </div>
    </div>

    @if($category->products->count() > 0)
        <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($category->products as $product)
                <div class="bg-white rounded-xl border border-gray-200 hover:shadow-md transition-all duration-200 overflow-hidden">
                    <div class="aspect-w-16 aspect-h-9">
                        <img class="w-full h-48 object-cover" 
                             src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/300x200?text=No+Image' }}" 
                             alt="{{ $product->name }}">
                    </div>
                    <div class="p-4">
                        <div class="flex items-start justify-between">
                            <h4 class="text-lg font-semibold text-gray-900 truncate flex-1">{{ $product->name }}</h4>
                            <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-500 mt-1">{{ Str::limit($product->description, 60) }}</p>
                        <div class="mt-4 flex items-center justify-between">
                            <div>
                                <p class="text-lg font-bold text-blue-600">
                                    @php
                                        $price = $product->price;
                                        if ($price >= 1000000) {
                                            echo 'Rp ' . number_format($price / 1000000, 1, ',', '.') . 'jt';
                                        } elseif ($price >= 1000) {
                                            echo 'Rp ' . number_format($price / 1000, 1, ',', '.') . 'rb';
                                        } else {
                                            echo 'Rp ' . number_format($price, 0, ',', '.');
                                        }
                                    @endphp
                                </p>
                                <p class="text-sm text-gray-500">Stok: {{ number_format($product->stock) }}</p>
                            </div>
                            <a href="{{ route('admin.products.show', $product) }}" class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white text-xs font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            @if($category->products_count > 10)
                <div class="mt-8 text-center">
                    <a href="{{ route('admin.products.index') }}?category={{ $category->slug }}" class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                        Lihat Semua Produk ({{ number_format($category->products_count) }})
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            @endif
        </div>
    @else
        <div class="text-center py-12">
            <div class="mx-auto h-24 w-24 text-gray-300 mb-6 flex items-center justify-center">
                <i class="fas fa-box-open text-6xl"></i>
            </div>
            <h4 class="text-xl font-bold text-gray-900 mb-3">Belum ada produk</h4>
            <p class="text-gray-500 mb-6 max-w-sm mx-auto">Kategori ini belum memiliki produk. Mulai tambahkan produk pertama.</p>
            <a href="{{ route('admin.products.create') }}?category={{ $category->slug }}" class="inline-flex items-center px-6 py-3 border border-transparent rounded-xl shadow-lg text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 transform hover:-translate-y-0.5 transition-all">
                <i class="fas fa-plus -ml-1 mr-2 h-4 w-4"></i>
                Tambah Produk
            </a>
        </div>
    @endif
</div>
@endsection