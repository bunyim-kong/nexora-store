<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    //
    protected $table = 'order_items';

    protected $primaryKey = 'id';

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
    ];

    public function orders() {
        return $this -> belongsTo(Order::class);
    }

    public function products() {
        return $this -> belongsTo(Product::class);
    }
}
