<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $table ='categories';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'slug',
        'des',
        'image_path',
    ];

    public function products() {
        return $this -> hasMany(Product::class);
    }
}
