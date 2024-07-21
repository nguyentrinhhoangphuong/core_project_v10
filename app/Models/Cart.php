<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    /**
     * MANY-TO-MANY KHÔNG ĐA HÌNH
     public function products()
     {
        return $this->belongsToMany(Product::class)->withPivot('quantity');
     }
     */

    // MANY-TO-MANY ĐA HÌNH
    public function products()
    {
        return $this->morphToMany(Product::class, 'productable')->withPivot('quantity');
    }

    public function getTotalAttribute()
    {
        return $this->products->pluck('total')->sum(); // total = getTotalAttribute() trong Product model
    }
}
