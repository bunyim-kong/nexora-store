<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = 'order_items';
    protected $primaryKey = 'id';

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
    ];

    // Fix relationship name - singular for belongsTo
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Fix relationship name - singular for belongsTo
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Fix typo in method name and remove ()
    public function getSubtotalAttribute()
    {
        return $this->price * $this->quantity;
    }
}