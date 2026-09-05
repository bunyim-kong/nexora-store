<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; // Add this import

class Order extends Model
{
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
        'latitude', // Add these
        'longitude',
        'formatted_address',
        'delivery_instructions',
        'google_maps_link',
    ];

    // Fix relationship name - singular for belongsTo
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Fix relationship name - plural for hasMany
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'bg-amber-100 text-amber-800',
            'confirmed' => 'bg-sky-100 text-sky-800',
            'processing' => 'bg-violet-100 text-violet-800',
            'shipped' => 'bg-teal-100 text-teal-800',
            'delivered' => 'bg-green-100 text-green-800',
            'cancelled' => 'bg-red-100 text-red-800',
        ];
        return $badges[$this->status] ?? 'bg-gray-100 text-gray-800';
    }

    public function getStatusTextAttribute()
    {
        return ucfirst($this->status);
    }

    public static function generateOrderNumber()
    {
        return 'ORD-' . Str::upper(Str::random(10));
    }
}