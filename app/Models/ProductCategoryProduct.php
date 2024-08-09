<?php

namespace App\Models;

use App\Models\Product;

class ProductCategoryProduct extends MainModel
{
  public function products()
  {
    return $this->belongsToMany(Product::class, 'product_category_product', 'category_product_id', 'product_id');
  }
}
