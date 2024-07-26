<?php

namespace App\View\Components\Admin\Order;

use App\Services\Order\OrderService;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Filter extends Component
{
    protected $status;
    protected $orderService;
    /**
     * Create a new component instance.
     */
    public function __construct(OrderService $orderService)
    {
        $this->status = config('order_status.status');
        $this->orderService = $orderService;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $status = $this->status;
        $orderCounts = $this->orderService->getOrderCountsByStatus();
        return view('components.admin.order.filter', compact('status', 'orderCounts'));
    }
}
