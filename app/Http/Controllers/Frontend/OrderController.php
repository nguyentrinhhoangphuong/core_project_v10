<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Services\Cart\CartService;
use App\Services\Order\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public $cartService;
    public $orderService;

    public function __construct(CartService $cartService, OrderService $orderService)
    {
        $this->cartService = $cartService;
        $this->orderService = $orderService;
    }

    public function create()
    {
        $cart = $this->cartService->getFromCookie();
        if (!$cart) {
            return redirect()->back();
        }
        return view('frontend.pages.order.create', compact('cart'));
    }

    public function store(OrderRequest $request)
    {
        $order = Order::create([
            'code' => $this->generateOrderCode(),
            'status' => 'pending',
            'total_amount' => $request->get('total_amount'),
            'gender' => $request->get('gender'),
            'name' => $request['name'],
            'phone' => $request['phone'],
            'email' => $request['email'],
            'address' => $request['address'],
            'options' => $request->get('options'),
        ]);

        $cart = $this->cartService->getFromCookie();
        $cartProductsWithQuantity = $cart->products->mapWithKeys(function ($product) {
            $quantity = $product->pivot->quantity;
            $product->decrement('qty', $quantity);
            return [$product->id => ['quantity' => $quantity]];
        });
        $order->products()->attach($cartProductsWithQuantity->toArray());
        $cart->products()->detach();
        $cart->delete();
        return view('frontend.pages.order.success', [
            'code' => $order->code
        ]);
    }

    private function generateOrderCode()
    {
        return 'ORD-' . strtoupper(uniqid());
    }

    public function tracking()
    {
        return view('frontend.pages.order.tracking');
    }

    public function trackingSubmit(Request $request)
    {
        $code = $request->code;
        $order  = $this->orderService->trackingCode($code);
        $statusForUser = config('order_status.for_user');
        $status = array_filter(config('order_status.status'), function ($key) use ($statusForUser) {
            return in_array($key, $statusForUser);
        }, ARRAY_FILTER_USE_KEY);
        // dump($order);
        // dd($status);
        if ($order) {
            return redirect()->back()->with(['order' => $order, 'status' => $status, 'code' => $code]);
        } else {
            return redirect()->back()->with('error', 'Không tìm thấy đơn hàng.');
        }
    }
}
