<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends MainModel
{
    use HasFactory;

    protected $fillble = [
        'status'
    ];

    public function payment()
    {
        return $this->hasOne(Payment::class, 'order_id');
    }

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
}
