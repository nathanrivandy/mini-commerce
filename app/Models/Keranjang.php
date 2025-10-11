<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    use HasFactory;

    protected $table = 'keranjang';

    protected $fillable = [
        'user_id',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(Item_Keranjang::class, 'keranjang_id');
    }

    // Accessors
    public function getTotalItemsAttribute()
    {
        return $this->items->sum('qty');
    }

    public function getTotalPriceAttribute()
    {
        return $this->items->sum(function ($item) {
            return $item->qty * $item->product->price;
        });
    }

    public function getFormattedTotalPriceAttribute()
    {
        return 'Rp ' . number_format($this->total_price, 0, ',', '.');
    }

    // Helper methods
    public function isEmpty()
    {
        return $this->items->isEmpty();
    }

    public function hasItem($productId)
    {
        return $this->items->where('product_id', $productId)->exists();
    }

    public function addItem($productId, $quantity = 1)
    {
        $existingItem = $this->items()->where('product_id', $productId)->first();
        
        if ($existingItem) {
            $existingItem->increment('qty', $quantity);
            return $existingItem;
        }

        return $this->items()->create([
            'product_id' => $productId,
            'qty' => $quantity,
        ]);
    }

    public function updateItemQuantity($productId, $quantity)
    {
        $item = $this->items()->where('product_id', $productId)->first();
        
        if ($item) {
            if ($quantity <= 0) {
                $item->delete();
            } else {
                $item->update(['qty' => $quantity]);
            }
        }
    }

    public function removeItem($productId)
    {
        $this->items()->where('product_id', $productId)->delete();
    }

    public function clear()
    {
        $this->items()->delete();
    }
    
    // Check if cart has items with issues (out of stock or inactive)
    public function hasIssues()
    {
        foreach ($this->items as $item) {
            if (!$item->product->is_active || $item->qty > $item->product->stock) {
                return true;
            }
        }
        return false;
    }
    
    // Get items with issues
    public function getItemsWithIssues()
    {
        return $this->items->filter(function ($item) {
            return !$item->product->is_active || $item->qty > $item->product->stock;
        });
    }
    
    // Remove inactive products from cart
    public function removeInactiveProducts()
    {
        foreach ($this->items as $item) {
            if (!$item->product->is_active) {
                $item->delete();
            }
        }
    }
    
    // Adjust quantities to match available stock
    public function adjustToAvailableStock()
    {
        foreach ($this->items as $item) {
            if ($item->qty > $item->product->stock) {
                if ($item->product->stock > 0) {
                    $item->update(['qty' => $item->product->stock]);
                } else {
                    $item->delete();
                }
            }
        }
    }
}