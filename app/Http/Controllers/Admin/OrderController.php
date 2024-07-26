<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Services\Order\OrderService;
use Illuminate\Http\Request;


class OrderController extends AdminController
{
    protected $orderService;
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
        view()->share('controllerName', $this->controllerName);
        $this->controllerName = 'order';
        $this->pathViewController = 'admin.pages.order.';
    }

    public function index(Request $request)
    {
        $items = $this->orderService->filterOrder($request, 20);
        return view($this->pathViewController . 'index', [
            'title' =>  'Order',
            'items' => $items
        ]);
    }

    public function orderDetail(Order $id)
    {
        $orderDetails = $this->orderService->getOrderDetails($id);
        return view($this->pathViewController . 'detail', [
            'title' => 'Chi tiết đơn hàng',
            'orderDetails' => $orderDetails
        ]);
    }

    public function orderChangeStatus(Request $request)
    {
        $orderId = $request->input('orderid');
        $status = $request->input('status');
        if ($this->orderService->updateOrderStatus($orderId, $status)) {
            return response()->json(['success' => true, 'message' => 'Trạng thái đơn hàng đã được cập nhật.']);
        }
        return response()->json(['success' => false, 'message' => 'Không thể cập nhật trạng thái.'], 400);
    }
}
