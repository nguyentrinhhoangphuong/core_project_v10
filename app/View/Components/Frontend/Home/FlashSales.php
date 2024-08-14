<?php

namespace App\View\Components\Frontend\Home;

use App\Models\FlashSale;
use App\Models\Product;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FlashSales extends Component
{
    /**
     * Create a new component instance.
     */
    protected $flashSales;
    protected $flashSaleProducts;
    protected $activeFlashSale;

    public function __construct(FlashSale $flashSale)
    {
        $this->flashSales = $flashSale;
        $this->getProductFlashSales();
    }

    public function getProductFlashSales()
    {
        $this->activeFlashSale = $this->flashSales->isActiveFlashSales();
        if ($this->activeFlashSale) {
            $this->flashSaleProducts = Product::activeFlashSale()
                ->with('flashSales')
                ->paginate(6);
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $flashSaleProducts = $this->flashSaleProducts;
        $activeFlashSale = $this->activeFlashSale;
        return view('components.frontend.home.flash-sales', compact('flashSaleProducts', 'activeFlashSale'));
    }
}
