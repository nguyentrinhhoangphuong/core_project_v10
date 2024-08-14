<?php

namespace App\Services\Order;

use App\Helpers\Template;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class OrderService
{
  protected $order;
  protected $product;
  protected $coupon;

  public function __construct(Order $order, Product $product, Coupon $coupon)
  {
    $this->order = $order;
    $this->product = $product;
    $this->coupon = $coupon;
  }

  public function getAllOrders()
  {
    return $this->order->all();
  }

  public function getCountOrders()
  {
    return $this->order->count();
  }

  public function getCountProduct()
  {
    return $this->product->count();
  }

  public function getTotalSale()
  {
    return $this->order->where('status', 'delivered')->sum('total_amount');
  }

  public function getlatestOrders()
  {
    return $this->order->where('status', 'pending')->limit(10)->get();
  }

  public function getTotalOrderdelivered()
  {
    return $this->order->where('status', 'delivered')->count();
  }

  public function getTotalOrderShipped()
  {
    return $this->order->where('status', 'shipped')->count();
  }

  public function getTotalOrderProcessing()
  {
    return $this->order->where('status', 'processing')->count();
  }

  public function getTotalOrderConfirmed()
  {
    return $this->order->where('status', 'confirmed')->count();
  }

  public function getTotalCouponValid()
  {
    return $this->coupon->countCouponValid();
  }

  public function filterOrder($request, $limit = 10)
  {
    $query = $this->order->query();
    if ($request->filled('status')) {
      $query->where('status', $request->status);
    }
    if ($request->filled('code')) {
      // $query->where('code', $request->code);
      $query->where('code', 'like', '%' . $request->code . '%');
    }
    return $query->paginate($limit);
  }

  public function getOrderCountsByStatus()
  {
    return $this->order->select('status', DB::raw('count(*) as total'))
      ->groupBy('status')
      ->pluck('total', 'status')
      ->all();
  }

  public function getOrderDetails($order)
  {
    $order = $this->order->with('products')->find($order->id);
    if (!$order) return null;

    // $orderDetails = [
    //   'id' => $order->id,
    //   'status' => $order->status,
    //   'customer_name' => $order->name,
    //   'code' => $order->code,
    //   'options' => $order->options,
    //   'total_amount' => $order->total_amount,
    //   'gender' => $order->gender,
    //   'address' => $order->address,
    //   'phone' => $order->phone,
    //   'email' => $order->address,
    //   'created_at' => Template::dateFormat($order->created_at),
    //   'coupon' => $order->coupon,
    //   'products' => $order->products->map(function ($product) {
    //     return [
    //       'id' => $product->pivot->product_id,
    //       'quantity' => $product->pivot->quantity,
    //       'name' => $product->name,
    //       'price' => $product->price,
    //       'image' => $product->media[0]->getUrl(),
    //     ];
    //   })
    // ];
    return $order;
  }

  public function updateOrderStatus($orderId, $status)
  {
    $order = $this->order->find($orderId);
    if (!$order) return false;
    $order->status = $status;
    return $order->save();
  }

  public function trackingCode($code)
  {
    $tracking = $this->order->where('code', $code)->value('status');
    return $tracking;
  }
}
