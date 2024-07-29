<?php

namespace App\Services\WishList;

use App\Helpers\Template;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class WishListService
{

  public function addToWithList($productId)
  {
    $wishlist = json_decode(Cookie::get('wishlist', '[]'), true);
    if (!in_array($productId, $wishlist)) {
      $wishlist[] = $productId;
      Cookie::queue('wishlist', json_encode($wishlist), 60 * 24 * 30); // Lưu cookie trong 30 ngày
    }
    return $wishlist;
  }

  public function removeFromWishList($productId)
  {
    // Lấy cookie và giải mã nó
    $wishlist = Cookie::get('wishlist');
    $wishlist = $wishlist ? json_decode($wishlist, true) : [];
    // Loại bỏ sản phẩm khỏi danh sách yêu thích
    $wishlist = array_diff($wishlist, [$productId]);
    Cookie::queue('wishlist', json_encode($wishlist), 60 * 24 * 30); // Lưu cookie trong 30 ngày
    return $wishlist;
  }


  public function getProductWithList($wishListID)
  {
    // Kiểm tra nếu $wishListID là null hoặc không phải mảng
    if ($wishListID === null || !is_array($wishListID)) {
      $wishListID = []; // Gán một mảng trống nếu nó null hoặc không phải mảng
    }
    $products = Product::whereIn('id', $wishListID)->paginate(10);
    return $products;
  }

  public function countProducts()
  {
    $wishlist = Cookie::get('wishlist');
    if ($wishlist === null) {
      return 0;
    }
    $decodedWishlist = json_decode($wishlist, true);
    if (!is_array($decodedWishlist)) {
      return 0;
    }
    return count($decodedWishlist);
  }

  public function isAddToWithList($productId)
  {
    $wishlist = json_decode(Cookie::get('wishlist', '[]'), true);
    if (in_array($productId, $wishlist)) {
      return true;
    }
    return false;
  }
}
