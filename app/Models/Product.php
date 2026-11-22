<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name','category','price','discount_price','description','sale_price'
    ];

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
}
