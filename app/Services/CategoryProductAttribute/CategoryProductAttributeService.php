<?php

namespace App\Services\CategoryProductAttribute;

use App\Models\CategoryProducts;
use App\Models\Attributes;
use App\Models\Brand;

class CategoryProductAttributeService
{
  public function getFilterAttributes($categoryId)
  {
    $category = CategoryProducts::findOrFail($categoryId);

    // Lấy tất cả id của danh mục hiện tại và tổ tiên của nó
    $ancestorsAndSelf = $category->ancestorsAndSelf($category->id)->pluck('id');

    // Lấy tất cả thuộc tính liên quan đến danh mục và tổ tiên của nó
    $attributes = Attributes::whereHas('categoryProducts', function ($query) use ($ancestorsAndSelf) {
      $query->whereIn('category_products.id', $ancestorsAndSelf);
    })
      ->where('is_filter', true)
      ->orderBy('ordering')
      ->with('attributeValue')   // Eager load các giá trị thuộc tính
      ->get();

    return $attributes;
  }

  public function getAllFilterAttributes()
  {
    return Attributes::where('is_filter', true)
      ->orderBy('ordering')
      ->with('attributeValue')
      ->get();
  }

  public function getRelevantFilterAttributes($products)
  {
    // Lấy tất cả ID sản phẩm từ collection hiện tại
    $productIds = $products->pluck('id')->toArray();

    // Lấy các thuộc tính liên quan đến các sản phẩm này
    $attributes = Attributes::whereHas('productAttributes', function ($query) use ($productIds) {
      $query->whereIn('product_id', $productIds);
    })
      ->where('is_filter', true)
      ->orderBy('ordering')
      ->with(['attributeValue' => function ($query) use ($productIds) {
        $query->whereHas('productAttributes', function ($subQuery) use ($productIds) {
          $subQuery->whereIn('product_id', $productIds);
        });
      }])
      ->get();

    return $attributes;
  }

  public function getRelevantBrands($products)
  {
    $productIds = $products->pluck('id')->toArray();

    $brands = Brand::whereHas('products', function ($query) use ($productIds) {
      $query->whereIn('id', $productIds);
    })
      ->select('id', 'name')
      ->orderBy('name')
      ->get();

    return $brands;
  }
}
