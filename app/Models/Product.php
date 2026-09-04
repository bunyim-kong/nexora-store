<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $table = 'products';

    protected $primaryKey = 'id';

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'des',
        'price',
        'stock',
        'image',
        'quantity',
        'discount_price',
        'is_best_seller',
        'is_featured',
        'brand',
    ];

    public function category() {
        return $this -> belongsTo(Category::class);
    }

    public function orderItem() {
        return $this -> hasMany(OrderItem::class);
    }

    public function getIsNewAttribute(): bool
    {
        return $this->created_at && $this->created_at->gt(now()->subDays(14));
    }

    public function getIsOnSaleAttribute(): bool
    {
        return !is_null($this->discount_price) && $this->discount_price < $this->price;
    }

    protected $cast = [
        'is_best_seller' => 'boolean',
        'is_featured' => 'boolean,'
    ];

    public static function booted() {
        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name) . '-' . Str::random(5);
            }
        });
    }
}
