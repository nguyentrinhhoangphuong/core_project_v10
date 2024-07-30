<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Series extends MainModel
{
    use HasFactory;

    protected $fillable = ['name', 'brand_id', 'slug'];

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'series_id');
    }

    public function scopeGetSeriesByBrandId($query, $brandId)
    {
        return $query->where('brand_id', $brandId);
    }
}
