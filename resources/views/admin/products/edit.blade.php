@extends('admin.layout')

@section('title', 'Edit Produk - Mini Commerce')
@section('page-title', 'Edit Produk')

@section('page-description')
<p class="mt-2 text-lg text-gray-600">Perbarui informasi produk "{{ $product->name }}".</p>
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
<div class="max-w-4xl mx-auto">
    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT')

        <!-- Basic Information -->
        <div class="bg-white shadow-lg rounded-xl border border-gray-100 overflow-hidden">
            <div class="px-8 py-6 bg-gray-50 border-b border-gray-200">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-primary-500 rounded-xl flex items-center justify-center mr-4 shadow-md">
                        <i class="fas fa-edit text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Informasi Dasar</h3>
                        <p class="mt-1 text-sm text-gray-600">Perbarui informasi dasar produk</p>
                    </div>
                </div>
            </div>

            <div class="p-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Left Column -->
                    <div class="space-y-6">
                        <!-- Product Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-tag mr-2 text-primary-600"></i>Nama Produk
                            </label>
                            <input type="text" 
                                   name="name" 
                                   id="name" 
                                   value="{{ old('name', $product->name) }}"
                                   class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('name') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror"
                                   placeholder="Masukkan nama produk..."
                                   required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Category -->
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-folder mr-2 text-primary-600"></i>Kategori
                            </label>
                            <select name="category_id" 
                                    id="category_id" 
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('category_id') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror"
                                    required>
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Price -->
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-money-bill-wave mr-2 text-primary-600"></i>Harga
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">Rp</span>
                                </div>
                                <input type="number" 
                                       name="price" 
                                       id="price" 
                                       value="{{ old('price', $product->price) }}"
                                       class="block w-full pl-10 rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('price') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror"
                                       placeholder="0"
                                       min="0"
                                       step="1000"
                                       required>
                            </div>
                            @error('price')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-6">
                        <!-- Stock -->
                        <div>
                            <label for="stock" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-boxes mr-2 text-primary-600"></i>Stok
                            </label>
                            <input type="number" 
                                   name="stock" 
                                   id="stock" 
                                   value="{{ old('stock', $product->stock) }}"
                                   class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('stock') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror"
                                   placeholder="0"
                                   min="0"
                                   required>
                            @error('stock')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="is_active" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-toggle-on mr-2 text-primary-600"></i>Status
                            </label>
                            <select name="is_active" 
                                    id="is_active" 
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('is_active') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror"
                                    required>
                                <option value="1" {{ old('is_active', $product->is_active) == 1 ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ old('is_active', $product->is_active) == 0 ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                            @error('is_active')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Current Product Info -->
                        <div class="bg-primary-50 rounded-lg p-4 border border-primary-200">
                            <h4 class="text-sm font-medium text-primary-900 mb-2">Informasi Saat Ini</h4>
                            <div class="text-sm text-primary-800 space-y-1">
                                <p><strong>Slug:</strong> {{ $product->slug }}</p>
                                <p><strong>Dibuat:</strong> {{ $product->created_at->format('d M Y H:i') }}</p>
                                <p><strong>Total Terjual:</strong> {{ number_format($product->orderItems->sum('quantity')) }} unit</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="mt-8">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-align-left mr-2 text-primary-600"></i>Deskripsi Produk
                    </label>
                    <textarea name="description" 
                              id="description" 
                              rows="4"
                              class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('description') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror"
                              placeholder="Masukkan deskripsi produk...">{{ old('description', $product->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Product Image -->
        <div class="bg-white shadow-lg rounded-xl border border-gray-100 overflow-hidden">
            <div class="px-8 py-6 bg-gray-50 border-b border-gray-200">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-secondary-500 rounded-xl flex items-center justify-center mr-4 shadow-md">
                        <i class="fas fa-image text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Gambar Produk</h3>
                        <p class="mt-1 text-sm text-gray-600">Upload gambar produk (opsional)</p>
                    </div>
                </div>
            </div>

            <div class="p-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Current Image -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">Gambar Saat Ini</label>
                        <div class="aspect-w-1 aspect-h-1">
                            <img class="w-full h-64 object-cover rounded-xl shadow-md border-2 border-gray-200" 
                                 src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/300x300?text=No+Image' }}" 
                                 alt="{{ $product->name }}"
                                 id="current-image">
                        </div>
                    </div>

                    <!-- Upload New Image -->
                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-3">
                            <i class="fas fa-cloud-upload-alt mr-2 text-secondary-600"></i>Upload Gambar Baru
                        </label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:border-secondary-400 transition-colors">
                            <div class="space-y-1 text-center">
                                <div class="mx-auto h-12 w-12 text-gray-400">
                                    <i class="fas fa-cloud-upload-alt text-4xl"></i>
                                </div>
                                <div class="flex text-sm text-gray-600">
                                    <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-secondary-600 hover:text-secondary-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-secondary-500">
                                        <span>Upload gambar</span>
                                        <input id="image" name="image" type="file" class="sr-only" accept="image/*" onchange="previewImage(this)">
                                    </label>
                                    <p class="pl-1">atau drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, JPEG hingga 2MB</p>
                            </div>
                        </div>
                        @error('image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-end">
            <button type="submit" 
                    class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-primary-500 hover:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transform hover:-translate-y-0.5 transition-all">
                <i class="fas fa-save mr-2"></i>
                Update Produk
            </button>
        </div>
    </form>
</div>

@if($product->orderItems->count() > 0)
<div class="max-w-4xl mx-auto mt-8">
    <div class="bg-warning-50 rounded-xl p-6 border border-warning-200">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-exclamation-triangle text-warning-500 text-xl"></i>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-warning-800">Perhatian</h3>
                <div class="mt-2 text-sm text-warning-700">
                    <p>Produk ini sudah ada dalam {{ number_format($product->orderItems->count()) }} pesanan dengan total {{ number_format($product->orderItems->sum('quantity')) }} unit terjual. Hati-hati saat mengubah harga atau informasi penting lainnya.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('current-image').src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection