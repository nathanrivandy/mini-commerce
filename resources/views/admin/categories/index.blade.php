@extends('admin.layout')

@section('title', 'Kelola Kategori - Mini Commerce')
@section('page-title', 'Kelola Kategori')

@section('page-description')
<p class="mt-2 text-lg text-gray-600">Kelola semua kategori produk di toko online Anda.</p>
@endsection

@section('page-actions')
<div class="flex flex-col sm:flex-row gap-3">
    <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center justify-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
        <i class="fas fa-plus -ml-0.5 mr-1.5 h-4 w-4"></i>
        Tambah Kategori
    </a>
</div>
@endsection

@section('content')

@if(session('success'))
    <div class="mb-6 rounded-xl bg-green-50 p-4 border border-green-200">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-check-circle text-green-400 text-lg"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
            </div>
        </div>
    </div>
@endif

@if(session('error'))
    <div class="mb-6 rounded-xl bg-red-50 p-4 border border-red-200">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-exclamation-circle text-red-400 text-lg"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
            </div>
        </div>
    </div>
@endif

<!-- Statistics Cards -->
<div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 mb-8">
    <!-- Total Categories -->
    <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-100">
        <div class="p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-tags text-white text-xl"></i>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Kategori</dt>
                        <dd class="text-3xl font-bold text-gray-900 mt-1">{{ number_format($categories->count()) }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Categories with Products -->
    <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-100">
        <div class="p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-check-circle text-white text-xl"></i>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Kategori Berisi</dt>
                        <dd class="text-3xl font-bold text-gray-900 mt-1">{{ number_format($categories->where('products_count', '>', 0)->count()) }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Empty Categories -->
    <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-100">
        <div class="p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-orange-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-exclamation-triangle text-white text-xl"></i>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Kategori Kosong</dt>
                        <dd class="text-3xl font-bold text-gray-900 mt-1">{{ number_format($categories->where('products_count', 0)->count()) }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="space-y-6">
    <!-- Categories Table Card -->
    <div class="bg-white shadow-lg rounded-xl border border-gray-100 overflow-hidden">
        <div class="px-8 py-6 bg-gray-50 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center mr-4 shadow-md">
                        <i class="fas fa-list text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Daftar Kategori</h3>
                        <p class="mt-1 text-sm text-gray-600">{{ number_format($categories->count()) }} kategori ditemukan</p>
                    </div>
                </div>
            </div>
        </div>

    @if($categories->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Kategori
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Deskripsi
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Jumlah Produk
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Dibuat
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($categories as $category)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                                    <i class="fas fa-tag text-blue-600"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $category->name }}</div>
                                    <div class="text-sm text-gray-500">/{{ $category->slug }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">
                                {{ Str::limit($category->description, 100) ?: '-' }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $category->products_count > 0 ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ number_format($category->products_count) }} produk
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $category->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end space-x-2">
                                <a href="{{ route('admin.categories.show', $category) }}" 
                                   class="inline-flex items-center justify-center w-9 h-9 bg-emerald-100 hover:bg-emerald-200 text-emerald-600 hover:text-emerald-700 rounded-lg transition-all duration-200 transform hover:scale-105 shadow-sm" 
                                   title="Lihat Detail">
                                    <i class="fas fa-eye text-sm"></i>
                                </a>
                                <a href="{{ route('admin.categories.edit', $category) }}" 
                                   class="inline-flex items-center justify-center w-9 h-9 bg-blue-100 hover:bg-blue-200 text-blue-600 hover:text-blue-700 rounded-lg transition-all duration-200 transform hover:scale-105 shadow-sm" 
                                   title="Edit">
                                    <i class="fas fa-edit text-sm"></i>
                                </a>
                                @if($category->products_count == 0)
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="inline-flex items-center justify-center w-9 h-9 bg-red-100 hover:bg-red-200 text-red-600 hover:text-red-700 rounded-lg transition-all duration-200 transform hover:scale-105 shadow-sm" 
                                            title="Hapus">
                                        <i class="fas fa-trash text-sm"></i>
                                    </button>
                                </form>
                                @else
                                <span class="inline-flex items-center justify-center w-9 h-9 bg-gray-100 text-gray-400 rounded-lg cursor-not-allowed" 
                                      title="Tidak dapat dihapus - masih ada produk">
                                    <i class="fas fa-trash text-sm"></i>
                                </span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="px-6 py-16 text-center">
            <div class="text-gray-500">
                <div class="w-20 h-20 bg-gray-100 rounded-xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-tags text-gray-400 text-3xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum ada kategori</h3>
                <p class="text-sm text-gray-600 mb-6">Mulai dengan menambahkan kategori pertama untuk mengorganisir produk Anda</p>
                <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    <i class="fas fa-plus -ml-0.5 mr-1.5 h-4 w-4"></i>
                    Tambah Kategori
                </a>
            </div>
        </div>
    @endif
</div>
@endsection