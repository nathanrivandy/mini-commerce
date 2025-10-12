<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Services\ProductService;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    protected $productService;
    protected $cartService;

    public function __construct(ProductService $productService, CartService $cartService)
    {
        $this->productService = $productService;
        $this->cartService = $cartService;
    }

    /**
     * Display a listing of products with optional filtering
     */
    public function index(Request $request)
    {
        $products = $this->productService->getProducts($request);
        $categories = Category::orderBy('name')->get();
        
        // Get cart data if user is authenticated
        $cartData = null;
        if (Auth::check()) {
            $cartData = $this->cartService->getCartSummary(Auth::user());
        }

        return view('products.index', compact('products', 'categories', 'cartData'));
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
        
        // Get cart data if user is authenticated
        $cartData = null;
        if (Auth::check()) {
            $cartData = $this->cartService->getCartSummary(Auth::user());
        }

        return view('products.index', compact('products', 'categories', 'category', 'cartData'));
    }

    /**
     * Search products
     */
    public function search(Request $request)
    {
        $products = $this->productService->getProducts($request);
        $categories = Category::orderBy('name')->get();
        $searchTerm = $request->get('search', '');
        
        // Get cart data if user is authenticated
        $cartData = null;
        if (Auth::check()) {
            $cartData = $this->cartService->getCartSummary(Auth::user());
        }

        return view('products.index', compact('products', 'categories', 'searchTerm', 'cartData'));
    }
}