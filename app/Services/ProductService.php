<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductService
{
    public function getProducts(Request $request)
    {
        $query = Product::with('category')->active();

        // Search by name or description
        if ($request->has('search') && $request->search) {
            $query->search($request->search);
        }

        // Filter by category
        if ($request->has('category') && $request->category) {
            if (is_numeric($request->category)) {
                $query->byCategory($request->category);
            } else {
                // Search by category slug
                $category = Category::where('slug', $request->category)->first();
                if ($category) {
                    $query->byCategory($category->id);
                }
            }
        }

        // Filter by price range
        if ($request->has('min_price') && $request->min_price) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->has('max_price') && $request->max_price) {
            $query->where('price', '<=', $request->max_price);
        }

        // Sort
        $sortBy = $request->get('sort', 'created_at');

        switch ($sortBy) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            case 'price':
                $query->orderBy('price', 'asc');
                break;
            case 'stock':
                $query->orderBy('stock', 'desc');
                break;
            case 'created_at':
            default:
                $query->orderBy('created_at', 'desc');
        }

        return $query->paginate(12);
    }

    public function getProductBySlug(string $slug): ?Product
    {
        return Product::with('category')->active()->where('slug', $slug)->first();
    }

    public function createProduct(array $data): array
    {
        try {
            // Handle image upload
            if (isset($data['image'])) {
                $data['image'] = $this->uploadImage($data['image']);
            }

            $product = Product::create($data);

            return [
                'success' => true,
                'message' => 'Produk berhasil dibuat',
                'product' => $product
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ];
        }
    }

    public function updateProduct(int $id, array $data): array
    {
        try {
            $product = Product::findOrFail($id);

            // Handle image upload
            if (isset($data['image'])) {
                // Delete old image
                if ($product->image) {
                    Storage::disk('public')->delete($product->image);
                }
                $data['image'] = $this->uploadImage($data['image']);
            }

            $product->update($data);

            return [
                'success' => true,
                'message' => 'Produk berhasil diperbarui',
                'product' => $product
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ];
        }
    }

    public function deleteProduct(int $id): array
    {
        try {
            $product = Product::findOrFail($id);

            // Delete image
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $product->delete();

            return [
                'success' => true,
                'message' => 'Produk berhasil dihapus'
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ];
        }
    }

    public function toggleProductStatus(int $id): array
    {
        try {
            $product = Product::findOrFail($id);
            $product->update(['is_active' => !$product->is_active]);

            $status = $product->is_active ? 'diaktifkan' : 'dinonaktifkan';

            return [
                'success' => true,
                'message' => "Produk berhasil {$status}"
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ];
        }
    }

    public function getFeaturedProducts(int $limit = 8)
    {
        return Product::with('category')
                     ->active()
                     ->inStock()
                     ->orderBy('created_at', 'desc')
                     ->limit($limit)
                     ->get();
    }

    public function getRelatedProducts(Product $product, int $limit = 4)
    {
        return Product::with('category')
                     ->active()
                     ->inStock()
                     ->where('category_id', $product->category_id)
                     ->where('id', '!=', $product->id)
                     ->orderBy('created_at', 'desc')
                     ->limit($limit)
                     ->get();
    }

    public function getLowStockProducts(int $threshold = 10)
    {
        return Product::with('category')
                     ->active()
                     ->where('stock', '<=', $threshold)
                     ->where('stock', '>', 0)
                     ->orderBy('stock', 'asc')
                     ->get();
    }

    public function getProductStatistics(): array
    {
        $total = Product::count();
        $active = Product::active()->count();
        $inactive = Product::where('is_active', false)->count();
        $outOfStock = Product::where('stock', 0)->count();
        $lowStock = Product::where('stock', '>', 0)->where('stock', '<=', 10)->count();

        return [
            'total_products' => $total,
            'active_products' => $active,
            'inactive_products' => $inactive,
            'out_of_stock' => $outOfStock,
            'low_stock' => $lowStock
        ];
    }

    private function uploadImage($image): string
    {
        $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
        return $image->storeAs('products', $filename, 'public');
    }
}