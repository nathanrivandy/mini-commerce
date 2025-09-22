<?php

namespace App\Services;

use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class OrderService
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function createOrder(User $user, array $data): array
    {
        try {
            DB::beginTransaction();

            $cart = $this->cartService->getOrCreateCart($user);

            // Validate cart not empty
            if ($cart->isEmpty()) {
                return [
                    'success' => false,
                    'message' => 'Keranjang kosong'
                ];
            }

            // Validate stock for all items
            foreach ($cart->items as $item) {
                if (!$item->product->hasStock($item->qty)) {
                    return [
                        'success' => false,
                        'message' => "Stok produk {$item->product->name} tidak mencukupi"
                    ];
                }
            }

            // Create order
            $order = Order::create([
                'user_id' => $user->id,
                'total' => $cart->total_price,
                'status' => Order::STATUS_PENDING,
                'address_text' => $data['address'],
                'phone' => $data['phone'],
                'notes' => $data['notes'] ?? null,
            ]);

            // Create order items and reduce stock
            foreach ($cart->items as $cartItem) {
                $product = $cartItem->product;
                
                // Create order item
                $order->items()->create([
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'price' => $product->price,
                    'qty' => $cartItem->qty,
                ]);

                // Reduce stock
                $product->reduceStock($cartItem->qty);
            }

            // Clear cart
            $cart->clear();

            DB::commit();

            return [
                'success' => true,
                'message' => 'Pesanan berhasil dibuat',
                'order' => $order
            ];

        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ];
        }
    }

    public function getUserOrders(User $user, int $perPage = 10)
    {
        return $user->orders()
                   ->with('items.product')
                   ->orderBy('created_at', 'desc')
                   ->paginate($perPage);
    }

    public function getOrderDetails(int $orderId, User $user = null): ?Order
    {
        $query = Order::with(['items.product', 'user']);

        if ($user && !$user->isAdmin()) {
            $query->where('user_id', $user->id);
        }

        return $query->find($orderId);
    }

    public function updateOrderStatus(int $orderId, string $status): array
    {
        try {
            $order = Order::findOrFail($orderId);

            if ($order->updateStatus($status)) {
                return [
                    'success' => true,
                    'message' => 'Status pesanan berhasil diperbarui'
                ];
            }

            return [
                'success' => false,
                'message' => 'Status tidak valid'
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ];
        }
    }

    public function cancelOrder(int $orderId, User $user = null): array
    {
        try {
            DB::beginTransaction();

            $order = Order::findOrFail($orderId);

            // Check permission
            if ($user && !$user->isAdmin() && $order->user_id !== $user->id) {
                return [
                    'success' => false,
                    'message' => 'Tidak memiliki akses untuk membatalkan pesanan ini'
                ];
            }

            if ($order->cancel()) {
                DB::commit();
                return [
                    'success' => true,
                    'message' => 'Pesanan berhasil dibatalkan'
                ];
            }

            return [
                'success' => false,
                'message' => 'Pesanan tidak dapat dibatalkan'
            ];

        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ];
        }
    }

    public function getOrderStatistics(): array
    {
        $total = Order::count();
        $pending = Order::pending()->count();
        $processing = Order::processing()->count();
        $completed = Order::where('status', Order::STATUS_DELIVERED)->count();
        $cancelled = Order::where('status', Order::STATUS_CANCELLED)->count();

        $totalRevenue = Order::whereIn('status', [
            Order::STATUS_PROCESSING,
            Order::STATUS_SHIPPED,
            Order::STATUS_DELIVERED
        ])->sum('total');

        return [
            'total_orders' => $total,
            'pending_orders' => $pending,
            'processing_orders' => $processing,
            'completed_orders' => $completed,
            'cancelled_orders' => $cancelled,
            'total_revenue' => $totalRevenue,
            'formatted_revenue' => 'Rp ' . number_format($totalRevenue, 0, ',', '.')
        ];
    }
}