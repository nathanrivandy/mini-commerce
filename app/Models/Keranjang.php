<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    use HasFactory;

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
        return $this->hasMany(Item_Keranjang::class);
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
}