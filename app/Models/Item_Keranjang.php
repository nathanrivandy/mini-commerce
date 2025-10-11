<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item_Keranjang extends Model
{
    use HasFactory;

    protected $table = 'item_keranjang';

    protected $fillable = [
        'keranjang_id',
        'product_id',
        'qty',
    ];

    // Relationships
    public function cart()
    {
        return $this->belongsTo(Keranjang::class, 'keranjang_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Accessors
    public function getSubtotalAttribute()
    {
        return $this->qty * $this->product->price;
    }

    public function getFormattedSubtotalAttribute()
    {
        return 'Rp ' . number_format($this->subtotal, 0, ',', '.');
    }

    // Helper methods
    public function canIncreaseQuantity($amount = 1)
    {
        return $this->product->hasStock($this->qty + $amount);
    }

    public function increaseQuantity($amount = 1)
    {
        if ($this->canIncreaseQuantity($amount)) {
            $this->increment('qty', $amount);
            return true;
        }
        return false;
    }

    public function decreaseQuantity($amount = 1)
    {
        if ($this->qty > $amount) {
            $this->decrement('qty', $amount);
            return true;
        } elseif ($this->qty == $amount) {
            $this->delete();
            return true;
        }
        return false;
    }
}