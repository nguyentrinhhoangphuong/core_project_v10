<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = ['discount_amount', 'coupon_id'];
    /**
     * MANY-TO-MANY KHÔNG ĐA HÌNH
     public function products()
     {
        return $this->belongsToMany(Product::class)->withPivot('quantity');
     }
     */

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    // MANY-TO-MANY ĐA HÌNH
    public function products()
    {
        return $this->morphToMany(Product::class, 'productable')->withPivot('quantity');
    }

    public function getTotalAttribute()
    {
        return $this->products->pluck('total')->sum() - ($this->discount_amount ?? 0); // total = getTotalAttribute() trong Product model
    }
}
