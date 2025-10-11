<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Display a listing of products with optional filtering
     */
    public function index(Request $request)
    {
        $products = $this->productService->getProducts($request);
        $categories = Category::orderBy('name')->get();

        return view('products.index', compact('products', 'categories'));
    }

    /**
     * Display the specified product
     */
    public function show($slug)
    {
        $product = $this->productService->getProductBySlug($slug);

        if (!$product) {
            abort(404, 'Produk tidak ditemukan');
        }

        $relatedProducts = $this->productService->getRelatedProducts($product);

        return view('products.show', compact('product', 'relatedProducts'));
    }

    /**
     * Display products by category
     */
    public function category($categorySlug, Request $request)
    {
        $category = Category::where('slug', $categorySlug)->firstOrFail();
        
        $request->merge(['category' => $category->id]);
        $products = $this->productService->getProducts($request);
        $categories = Category::orderBy('name')->get();

        return view('products.index', compact('products', 'categories', 'category'));
    }

    /**
     * Search products
     */
    public function search(Request $request)
    {
        $products = $this->productService->getProducts($request);
        $categories = Category::orderBy('name')->get();
        $searchTerm = $request->get('search', '');

        return view('products.index', compact('products', 'categories', 'searchTerm'));
    }
}