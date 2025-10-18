<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->middleware('auth');
        $this->orderService = $orderService;
    }

    public function index(Request $request)
    {
        $query = Auth::user()->orders()->with(['items.product'])->latest();
        
        // Filter by status if provided
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }
        
        $orders = $query->paginate(10);
        
        return view('orders', compact('orders'));
    }

    public function create()
    {
        // Redirect to checkout page
        return redirect()->route('checkout.index');
    }

    public function store(Request $request)
    {
        // Redirect to checkout store
        return redirect()->route('checkout.store');
    }

    public function show($id)
    {
        $order = $this->orderService->getOrderDetails($id, Auth::user());

        if (!$order) {
            abort(404, 'Pesanan tidak ditemukan');
        }

        return view('orders.show', compact('order'));
    }

    public function cancel($id)
    {
        $result = $this->orderService->cancelOrder($id, Auth::user());

        if ($result['success']) {
            return redirect()->back()->with('success', $result['message']);
        }

        return redirect()->back()->with('error', $result['message']);
    }
}