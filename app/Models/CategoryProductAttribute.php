<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryProductAttribute extends Model
{
    use HasFactory;

    protected $fillable = ['category_product_id', 'attribute_id'];

    public function category()
    {
        return $this->belongsTo(CategoryProducts::class, 'category_product_id');
    }

    public function attribute()
    {
        return $this->belongsTo(Attributes::class, 'attribute_id');
    }
}
