<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    protected $cartService;
    protected $orderService;

    public function __construct(CartService $cartService, OrderService $orderService)
    {
        $this->middleware('auth');
        $this->cartService = $cartService;
        $this->orderService = $orderService;
    }

    public function index()
    {
        $cartSummary = $this->cartService->getCartSummary(Auth::user());
        
        // Check if cart is empty
        if (!$cartSummary['items'] || $cartSummary['items']->count() === 0) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja Anda kosong');
        }

        // Check stock availability for all items
        foreach ($cartSummary['items'] as $item) {
            if (!$item->product->hasStock($item->qty)) {
                return redirect()->route('cart.index')->with('error', 
                    "Stok produk {$item->product->name} tidak mencukupi. Tersedia: {$item->product->stock}");
            }
        }

        return view('checkout.index', $cartSummary);
    }

    public function store(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string|max:500',
            'phone' => 'required|string|max:20',
            'notes' => 'nullable|string|max:500'
        ]);

        $cartSummary = $this->cartService->getCartSummary(Auth::user());
        
        // Check if cart is empty
        if (!$cartSummary['items'] || $cartSummary['items']->count() === 0) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja Anda kosong');
        }

        $orderData = [
            'address' => $request->shipping_address,
            'phone' => $request->phone,
            'notes' => $request->notes
        ];

        $result = $this->orderService->createOrder(Auth::user(), $orderData);

        if ($result['success']) {
            // Clear cart after successful order
            $this->cartService->clearCart(Auth::user());
            
            return redirect()->route('orders.show', $result['order']->id)
                            ->with('success', 'Pesanan berhasil dibuat!');
        }

        return redirect()->back()
                        ->withInput()
                        ->with('error', $result['message']);
    }
}