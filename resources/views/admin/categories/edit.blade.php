@extends('admin.layout')

@section('title', 'Edit Kategori - Riloka')
@section('page-title', 'Edit Kategori')

@section('page-description')
<p class="mt-2 text-lg text-gray-600">Perbarui informasi kategori "{{ $category->name }}".</p>
@endsection

@section('page-actions')
<div class="flex flex-col sm:flex-row gap-3">
    <a href="{{ route('admin.categories.show', $category) }}" class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-lg hover:bg-blue-700 hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
        <i class="fas fa-eye -ml-0.5 mr-2 h-4 w-4"></i>
        Lihat Detail
    </a>
    <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center justify-center rounded-xl bg-white px-6 py-3 text-sm font-semibold text-gray-700 shadow-lg ring-1 ring-gray-200 hover:bg-gray-50 hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
        <i class="fas fa-arrow-left -ml-0.5 mr-2 h-4 w-4"></i>
        Kembali
    </a>
</div>
@endsection

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white shadow-lg rounded-xl border border-gray-100 overflow-hidden">
        <div class="px-8 py-6 bg-gray-50 border-b border-gray-200">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center mr-4 shadow-md">
                    <i class="fas fa-edit text-white text-xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Form Edit Kategori</h3>
                    <p class="mt-1 text-sm text-gray-600">Perbarui informasi kategori</p>
                </div>
            </div>
        </div>

        <div class="p-8">
            <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Category Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-tag mr-2 text-blue-600"></i>Nama Kategori
                    </label>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           value="{{ old('name', $category->name) }}"
                           class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('name') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror"
                           placeholder="Masukkan nama kategori..."
                           required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">Slug saat ini: <span class="font-mono text-blue-600">{{ $category->slug }}</span></p>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-align-left mr-2 text-blue-600"></i>Deskripsi
                    </label>
                    <textarea name="description" 
                              id="description" 
                              rows="4"
                              class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('description') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror"
                              placeholder="Masukkan deskripsi kategori (opsional)...">{{ old('description', $category->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">Deskripsi singkat tentang kategori ini</p>
                </div>

                <!-- Category Info -->
                <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                    <h4 class="text-sm font-medium text-blue-900 mb-2">Informasi Kategori</h4>
                    <div class="text-sm text-blue-800 space-y-1">
                        <p><strong>Jumlah produk:</strong> {{ number_format($category->products_count) }} produk</p>
                        <p><strong>Dibuat:</strong> {{ $category->created_at->format('d M Y H:i') }}</p>
                        <p><strong>Terakhir diupdate:</strong> {{ $category->updated_at->format('d M Y H:i') }}</p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.categories.index') }}" 
                       class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        <i class="fas fa-times mr-2"></i>
                        Batal
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transform hover:-translate-y-0.5 transition-all">
                        <i class="fas fa-save mr-2"></i>
                        Update Kategori
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@if($category->products_count > 0)
<div class="max-w-2xl mx-auto mt-8">
    <div class="bg-yellow-50 rounded-xl p-6 border border-yellow-200">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-exclamation-triangle text-yellow-400 text-xl"></i>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-yellow-800">Perhatian</h3>
                <div class="mt-2 text-sm text-yellow-700">
                    <p>Kategori ini memiliki {{ number_format($category->products_count) }} produk. Mengubah nama kategori akan memperbarui slug dan dapat mempengaruhi URL produk.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection