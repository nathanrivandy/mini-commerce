<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
        
        // Check for any issues with cart items
        $hasIssues = false;
        $issues = [];
        
        foreach ($cartSummary['items'] as $item) {
            if (!$item->product->is_active) {
                $issues[] = "Produk '{$item->product->name}' tidak lagi tersedia";
                $hasIssues = true;
            } elseif ($item->qty > $item->product->stock) {
                $issues[] = "Stok produk '{$item->product->name}' tidak mencukupi (tersedia: {$item->product->stock})";
                $hasIssues = true;
            }
        }
        
        if ($hasIssues) {
            session()->flash('warning', implode('. ', $issues));
        }
        
        return view('cart.index', $cartSummary);
    }

    public function add(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|integer|exists:products,id',
                'quantity' => 'required|integer|min:1'
            ]);

            $result = $this->cartService->addToCart(
                Auth::user(), 
                $request->product_id, 
                $request->quantity
            );

            // Always return JSON for API routes
            if ($request->expectsJson() || $request->wantsJson() || $request->is('api/*')) {
                return response()->json($result, $result['success'] ? 200 : 422);
            }

            if ($result['success']) {
                return redirect()->back()->with('success', $result['message']);
            }

            return redirect()->back()->with('error', $result['message']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson() || $request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal: ' . implode(', ', $e->validator->errors()->all())
                ], 422);
            }
            throw $e;
        } catch (\Exception $e) {
            Log::error('Cart add error: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'product_id' => $request->product_id ?? null,
                'trace' => $e->getTraceAsString()
            ]);
            
            if ($request->expectsJson() || $request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $productId)
    {
        try {
            $request->validate([
                'quantity' => 'required|integer|min:1'
            ]);

            $result = $this->cartService->updateQuantity(
                Auth::user(), 
                $productId, 
                $request->quantity
            );

            if ($request->expectsJson() || $request->wantsJson()) {
                return response()->json($result);
            }

            if ($result['success']) {
                return redirect()->back()->with('success', $result['message']);
            }

            return redirect()->back()->with('error', $result['message']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal: ' . implode(', ', $e->validator->errors()->all())
                ], 422);
            }
            throw $e;
        } catch (\Exception $e) {
            if ($request->expectsJson() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function remove($productId)
    {
        try {
            $result = $this->cartService->removeFromCart(Auth::user(), $productId);

            if (request()->expectsJson() || request()->wantsJson()) {
                return response()->json($result);
            }

            if ($result['success']) {
                return redirect()->back()->with('success', $result['message']);
            }

            return redirect()->back()->with('error', $result['message']);
        } catch (\Exception $e) {
            if (request()->expectsJson() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function clear()
    {
        try {
            $result = $this->cartService->clearCart(Auth::user());

            if (request()->expectsJson() || request()->wantsJson()) {
                return response()->json($result);
            }

            if ($result['success']) {
                return redirect()->back()->with('success', $result['message']);
            }

            return redirect()->back()->with('error', $result['message']);
        } catch (\Exception $e) {
            if (request()->expectsJson() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function count()
    {
        $cartSummary = $this->cartService->getCartSummary(Auth::user());
        return response()->json(['count' => $cartSummary['total_items']]);
    }
}