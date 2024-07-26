<?php

namespace App\View\Components\Admin\Order;

use App\Services\Order\OrderService;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Search extends Component
{
    protected $orderService;
    /**
     * Create a new component instance.
     */
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.order.search');
    }
}
