<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\Template;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Coupon;
use App\Services\Cart\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public $cartService;
    public $coupon;

    public function __construct(CartService $cartService, Coupon $coupon)
    {
        $this->cartService = $cartService;
        $this->coupon = $coupon;
    }

    public function index()
    {
        $cart = $this->cartService->getFromCookie();
        $total = $this->cartService->getTotal();
        if ($cart && $cart->coupon && $cart->coupon->hasReachedLimit()) {
            $cart = $this->cartService->updateDiscount(0, null);
            session()->flash('coupon_expired', 'Mã giảm giá đã hết hạn và đã bị xóa khỏi giỏ hàng của bạn.');
        }
        return view('frontend.pages.cart.index', compact('cart', 'total'));
    }

    public function applyCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'total' => 'required|numeric'
        ]);
        $coupon = Coupon::where('code', $request->code)->first();

        if ($this->cartService->checkCoupon()) {
            return response()->json([
                'success' => true,
                'message' => 'Mã giảm giá đã áp dụng cho đơn hàng',
            ]);
        }

        if (!$coupon || !$coupon->isValid($request->total)) {
            return response()->json(['error' => 'Mã giảm giá không hợp lệ hoặc không áp dụng được cho đơn hàng này'], 400);
        }

        $discountedTotal = $coupon->applyDiscount($request->total);
        $discountAmount = $request->total - $discountedTotal;
        $this->cartService->updateDiscount($discountAmount, $coupon->id);

        return response()->json([
            'success' => true,
            'message' => 'Mã giảm giá đã áp dụng cho đơn hàng',
            'discount_amount' => Template::numberFormatVND($discountAmount),
            'discounted_total' => Template::numberFormatVND($discountedTotal),
            'original_total' => Template::numberFormatVND($request->total),
            'delete_coupon' => route('frontend.home.deleteCoupon', ['coupon' => $coupon->id]),
        ]);
    }

    public function deleteCoupon(Request $request)
    {
        $cart = $this->cartService->updateDiscount(0, null);
        return response()->json([
            'success' => true,
            'message' => 'Đã xóa mã giảm giá',
            'discounted_total' => Template::numberFormatVND($cart->total),
        ]);
    }
}
