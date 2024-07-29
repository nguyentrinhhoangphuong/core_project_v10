<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\Template;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Services\Cart\CartService;
use Illuminate\Http\Request;


// lưu Order, Cart cho Productable
class ProductCartController extends Controller
{
    public $cartService;
    protected $cart;

    public function __construct(CartService $cartService, Cart $cart)
    {
        $this->cartService = $cartService;
        $this->cart = $cart;
    }

    public function store(Request $request)
    {
        $cart = $this->cartService->getFromCookieOrCreate();
        $productid = $request->productid;
        $quantity = $cart->products()
            ->find($productid)
            ->pivot
            ->quantity ?? 0;

        $cart->products()->syncWithoutDetaching([$productid => ['quantity' => $quantity + 1]]);
        $cookie = $this->cartService->makeCookie($cart);
        $countProducts = $this->cartService->countProducts();

        // Lấy thông tin chi tiết về giỏ hàng
        $cartData = [
            'products' => $cart->products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'price_formatted' => Template::numberFormatVND($product->price),
                    'quantity' => $product->pivot->quantity,
                    'image' => $product->media[0]->getUrl(),
                ];
            }),
            'total' => $cart->total,
            'total_formatted' => Template::numberFormatVND($cart->total),
            'cart_url' => route('frontend.cart.index'),
        ];

        return response()->json([
            'success' => true,
            'message' => 'Sản phẩm đã được thêm vào giỏ hàng',
            'countProducts' => $countProducts,
            'cartData' => $cartData
        ])->withCookie($cookie);
    }


    public function updateQuantity(Request $request)
    {
        // Lấy giỏ hàng từ cookie
        $cart = $this->cartService->getFromCookieOrCreate();
        if (!$cart) {
            return redirect()->back()->with('error', 'Giỏ hàng không tồn tại');
        }
        $products = $request->input('products', []);
        foreach ($products as $productId => $productData) {
            $quantity = $productData['quantity'];
            // Kiểm tra xem số lượng có hợp lệ không
            if ($quantity < 1) {
                continue; // Bỏ qua nếu số lượng không hợp lệ
            }
            // Cập nhật số lượng sản phẩm trong giỏ hàng
            $cart->products()->syncWithoutDetaching([
                $productId => ['quantity' => $quantity]
            ]);
        }
        // Tạo lại cookie với giỏ hàng đã cập nhật
        $cookie = $this->cartService->makeCookie($cart);
        // Trả về redirect với cookie và thông báo thành công
        return redirect()->back()->withCookie($cookie)->with('success', 'Giỏ hàng đã được cập nhật');
    }

    public function destroy(Request $request)
    {
        // Lấy giỏ hàng từ cookie
        $cart = $this->cartService->getFromCookieOrCreate();
        // Kiểm tra giỏ hàng và xóa sản phẩm nếu tồn tại
        if ($cart) {
            $cart->products()->detach($request->product_id);
            if ($cart->products->isEmpty()) {
                $cart->delete();
            }
            $cookie = $this->cartService->makeCookie($cart);
            return redirect()->back()->withCookie($cookie);
        }
        return redirect()->back()->with('error', 'Giỏ hàng không tồn tại');
    }
}
