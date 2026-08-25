<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $table = 'orders';

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'customer_name',
        'phone_number',
        'address',
        'payment_method',
        'subtotal',
        'delivery_fee',
        'total',
        'status',
    ];

    public function users() {
        return $this -> belongsTo(User::class);
    }

    public function orderItem() {
        return $this -> hasMany(OrderItem::class);
    }
}
