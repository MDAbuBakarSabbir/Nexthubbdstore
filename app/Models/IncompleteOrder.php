<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncompleteOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'name',
        'phone',
        'address',
        'cart_details',
        'status',
    ];

    public function getAmountAttribute()
    {
        $cart = $this->cart_details ? json_decode($this->cart_details) : null;
        $total = 0;
        if ($cart) {
            foreach ($cart as $item) {
                if (isset($item->price) && isset($item->qty)) {
                    $total += ($item->price * $item->qty);
                } elseif (isset($item['price']) && isset($item['qty'])) {
                    $total += ($item['price'] * $item['qty']);
                }
            }
        }
        return $total;
    }
}
