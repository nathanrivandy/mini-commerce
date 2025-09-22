<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Keranjang;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CartService
{
    public function getOrCreateCart(User $user): Keranjang
    {
        return $user->getOrCreateCart();
    }

    public function addToCart(User $user, int $productId, int $quantity = 1): array
    {
        try {
            DB::beginTransaction();

            $product = Product::active()->findOrFail($productId);
            $cart = $this->getOrCreateCart($user);

            // Check stock availability
            if (!$product->hasStock($quantity)) {
                return [
                    'success' => false,
                    'message' => 'Stok produk tidak mencukupi'
                ];
            }

            // Check if item already exists in cart
            $existingItem = $cart->items()->where('product_id', $productId)->first();
            
            if ($existingItem) {
                $newQuantity = $existingItem->qty + $quantity;
                
                if (!$product->hasStock($newQuantity)) {
                    return [
                        'success' => false,
                        'message' => 'Jumlah melebihi stok yang tersedia'
                    ];
                }
                
                $existingItem->update(['qty' => $newQuantity]);
            } else {
                $cart->items()->create([
                    'product_id' => $productId,
                    'qty' => $quantity
                ]);
            }

            DB::commit();

            return [
                'success' => true,
                'message' => 'Produk berhasil ditambahkan ke keranjang'
            ];

        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ];
        }
    }

    public function updateQuantity(User $user, int $productId, int $quantity): array
    {
        try {
            $cart = $this->getOrCreateCart($user);
            $item = $cart->items()->where('product_id', $productId)->first();

            if (!$item) {
                return [
                    'success' => false,
                    'message' => 'Item tidak ditemukan di keranjang'
                ];
            }

            if ($quantity <= 0) {
                $item->delete();
                return [
                    'success' => true,
                    'message' => 'Item berhasil dihapus dari keranjang'
                ];
            }

            // Check stock
            if (!$item->product->hasStock($quantity)) {
                return [
                    'success' => false,
                    'message' => 'Stok tidak mencukupi'
                ];
            }

            $item->update(['qty' => $quantity]);

            return [
                'success' => true,
                'message' => 'Jumlah item berhasil diperbarui'
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ];
        }
    }

    public function removeFromCart(User $user, int $productId): array
    {
        try {
            $cart = $this->getOrCreateCart($user);
            $deleted = $cart->items()->where('product_id', $productId)->delete();

            if ($deleted) {
                return [
                    'success' => true,
                    'message' => 'Item berhasil dihapus dari keranjang'
                ];
            }

            return [
                'success' => false,
                'message' => 'Item tidak ditemukan di keranjang'
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ];
        }
    }

    public function clearCart(User $user): array
    {
        try {
            $cart = $this->getOrCreateCart($user);
            $cart->clear();

            return [
                'success' => true,
                'message' => 'Keranjang berhasil dikosongkan'
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ];
        }
    }

    public function getCartSummary(User $user): array
    {
        $cart = $this->getOrCreateCart($user);
        
        return [
            'total_items' => $cart->total_items,
            'total_price' => $cart->total_price,
            'formatted_total' => $cart->formatted_total_price,
            'items' => $cart->items->load('product')
        ];
    }
}