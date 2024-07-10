<?php

namespace App\View\Components\Frontend\Home;

use App\Models\Brand;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ProductsGroupedByBrand extends Component
{
    protected $brands;
    /**
     * Create a new component instance.
     */
    public function __construct(Brand $brands)
    {
        $this->brands = $brands->getProductsGroupedByBrand();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.frontend.home.products-grouped-by-brand', [
            'productsByBrand' => $this->brands
        ]);
    }
}
