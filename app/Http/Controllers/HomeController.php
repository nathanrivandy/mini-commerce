<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Services\ProductService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        $categories = Category::withCount('activeProducts')
                             ->orderBy('name')
                             ->get();
        
        $featuredProducts = $this->productService->getFeaturedProducts(8);

        return view('home', compact('categories', 'featuredProducts'));
    }
}