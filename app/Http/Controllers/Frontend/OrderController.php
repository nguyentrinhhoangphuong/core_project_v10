<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Services\Cart\CartService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
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
}
