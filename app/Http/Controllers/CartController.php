<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->middleware('auth');
        $this->cartService = $cartService;
    }

    public function index()
    {
        $cartSummary = $this->cartService->getCartSummary(Auth::user());
        return view('cart.index', $cartSummary);
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $result = $this->cartService->addToCart(
            Auth::user(), 
            $request->product_id, 
            $request->quantity
        );

        if ($request->expectsJson()) {
            return response()->json($result);
        }

        if ($result['success']) {
            return redirect()->back()->with('success', $result['message']);
        }

        return redirect()->back()->with('error', $result['message']);
    }

    public function update(Request $request, $productId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0'
        ]);

        $result = $this->cartService->updateQuantity(
            Auth::user(), 
            $productId, 
            $request->quantity
        );

        if ($request->expectsJson()) {
            return response()->json($result);
        }

        if ($result['success']) {
            return redirect()->back()->with('success', $result['message']);
        }

        return redirect()->back()->with('error', $result['message']);
    }

    public function remove($productId)
    {
        $result = $this->cartService->removeFromCart(Auth::user(), $productId);

        if (request()->expectsJson()) {
            return response()->json($result);
        }

        if ($result['success']) {
            return redirect()->back()->with('success', $result['message']);
        }

        return redirect()->back()->with('error', $result['message']);
    }

    public function clear()
    {
        $result = $this->cartService->clearCart(Auth::user());

        if (request()->expectsJson()) {
            return response()->json($result);
        }

        if ($result['success']) {
            return redirect()->back()->with('success', $result['message']);
        }

        return redirect()->back()->with('error', $result['message']);
    }

    public function count()
    {
        $cartSummary = $this->cartService->getCartSummary(Auth::user());
        return response()->json(['count' => $cartSummary['total_items']]);
    }
}