<?php

namespace App\View\Components\Frontend\Home\Products;

use App\Models\Product;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TrendingProducts extends Component
{
    protected $trendingProducts;
    /**
     * Create a new component instance.
     */
    public function __construct($trendingProducts)
    {
        $this->trendingProducts = $trendingProducts;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.frontend.home.products.trending-products', [
            'trendingProducts' => $this->trendingProducts
        ]);
    }
}
