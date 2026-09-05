<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'customer_name',
        'phone_number',
        'address',
        'delivery_method',
        'payment_method',
        'payment_status',
        'payment_id',
        'paid_at',
        'subtotal',
        'delivery_fee',
        'total',
        'status',
        'latitude', 
        'longitude',                   
        'formatted_address',           
        'delivery_instructions',       
        'google_maps_link',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Status Badges
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

    // Payment Status Badges
    public function getPaymentStatusBadgeAttribute()
    {
        $badges = [
            'unpaid' => 'bg-yellow-100 text-yellow-800',
            'paid' => 'bg-green-100 text-green-800',
            'failed' => 'bg-red-100 text-red-800',
        ];
        return $badges[$this->payment_status] ?? 'bg-gray-100 text-gray-800';
    }

    public function getPaymentStatusTextAttribute()
    {
        $texts = [
            'unpaid' => 'Unpaid',
            'paid' => 'Paid ',
            'failed' => 'Failed ',
        ];
        return $texts[$this->payment_status] ?? ucfirst($this->payment_status);
    }

    public function getDeliveryMethodBadgeAttribute()
    {
        if ($this->delivery_method === 'pickup') {
            return '🏪 Store Pickup';
        }
        return '🚚 Standard Delivery';
    }

    public static function generateOrderNumber()
    {
        return 'ORD-' . Str::upper(Str::random(10));
    }
}