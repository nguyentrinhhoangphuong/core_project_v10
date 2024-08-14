<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlashSale extends Model
{
    use HasFactory;
    protected $dates = ['start_time', 'end_time'];
    protected $fillable = ['name', 'discount_percentage', 'start_time', 'end_time', 'is_active'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'flash_sale_product');
    }

    public function isActiveFlashSales()
    {
        $currentTime = now();
        $activeFlashSale = FlashSale::where('start_time', '<=', $currentTime)
            ->where('end_time', '>=', $currentTime)
            ->where('is_active', true)
            ->first();
        return $activeFlashSale;
    }
}
