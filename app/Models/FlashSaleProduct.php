<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlashSaleProduct extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['flash_sale_id', 'product_id'];
}
