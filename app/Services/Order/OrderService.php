<?php

namespace App\Services\Order;

use App\Helpers\Template;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderService
{
  protected $order;

  public function __construct(Order $order)
  {
    $this->order = $order;
  }

  public function getAllOrders()
  {
    return $this->order->all();
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

    $orderDetails = [
      'id' => $order->id,
      'status' => $order->status,
      'customer_name' => $order->name,
      'code' => $order->code,
      'options' => $order->options,
      'total_amount' => $order->total_amount,
      'gender' => $order->gender,
      'address' => $order->address,
      'phone' => $order->phone,
      'email' => $order->address,
      'created_at' => Template::dateFormat($order->created_at),
      'products' => $order->products->map(function ($product) {
        return [
          'id' => $product->pivot->product_id,
          'quantity' => $product->pivot->quantity,
          'name' => $product->name,
          'price' => $product->price,
          'image' => $product->media[0]->getUrl(),
        ];
      })
    ];
    return $orderDetails;
  }

  public function updateOrderStatus($orderId, $status)
  {
    $order = $this->order->find($orderId);
    if (!$order) return false;
    $order->status = $status;
    return $order->save();
  }
}
