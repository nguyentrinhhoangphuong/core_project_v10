<?php

namespace App\Services\Cart;

use App\Models\Cart;
use Illuminate\Support\Facades\Cookie;

class CartService
{
  protected $cookieName;
  protected $cookieExpiration;

  public function __construct()
  {
    $this->cookieName = config('cart.cookie.name');
    $this->cookieExpiration = config('cart.cookie.expiration');
  }

  public function getFromCookie()
  {
    $cartId = Cookie::get($this->cookieName);
    return Cart::find($cartId);
  }

  public function getFromCookieOrCreate()
  {
    $cart = $this->getFromCookie();
    return $cart ?? Cart::create();
  }

  public function makeCookie(Cart $cart)
  {
    return Cookie::make($this->cookieName, $cart->id, $this->cookieExpiration);
  }

  public function countProducts()
  {
    $cart = $this->getFromCookie();
    if ($cart != null) {
      return $cart->products->pluck('pivot.quantity')->sum();
    }
    return 0;
  }

  public function updateDiscount($discountAmount, $couponId)
  {
    $cart = $this->getFromCookieOrCreate();
    $cart->update(['discount_amount' => $discountAmount, 'coupon_id' => $couponId]);
    return $cart;
  }

  public function checkCoupon()
  {
    $cart = $this->getFromCookieOrCreate();
    return $cart->coupon_id != null ? true : false;
  }

  public function getTotal()
  {
    $cart = $this->getFromCookie();
    if ($cart != null) {
      return $cart->products->pluck('total')->sum();
    }
    return 0;
  }
}
