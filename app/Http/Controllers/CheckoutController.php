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

        return view('checkout', [
            'items' => $cartSummary['items'],
            'subtotal' => $cartSummary['total_price'],
            'total' => $cartSummary['total_price'],
            'totalItems' => $cartSummary['total_items']
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'recipient_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'shipping_address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
            'payment_method' => 'required|in:bank_transfer,e_wallet,cod',
            'notes' => 'nullable|string|max:500'
        ]);

        $cartSummary = $this->cartService->getCartSummary(Auth::user());
        
        // Check if cart is empty
        if (!$cartSummary['items'] || $cartSummary['items']->count() === 0) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja Anda kosong');
        }

        // Combine address
        $fullAddress = $request->shipping_address . ', ' . $request->city . ', ' . $request->postal_code;

        $orderData = [
            'address' => $fullAddress,
            'phone' => $request->phone,
            'notes' => $request->notes,
            'payment_method' => $request->payment_method
        ];

        $result = $this->orderService->createOrder(Auth::user(), $orderData);

        if ($result['success']) {
            // Clear cart after successful order
            $this->cartService->clearCart(Auth::user());
            
            return redirect()->route('orders.show', $result['order']->id)
                            ->with('success', 'Pesanan berhasil dibuat! Pesanan Anda sedang diproses.');
        }

        return redirect()->back()
                        ->withInput()
                        ->with('error', $result['message']);
    }
}