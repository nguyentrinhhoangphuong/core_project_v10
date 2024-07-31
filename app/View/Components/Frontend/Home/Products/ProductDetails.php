<?php

namespace App\View\Components\Frontend\Home\Products;

use App\Models\Product;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ProductDetails extends Component
{
    protected $product;
    public $seriesProducts;
    /**
     * Create a new component instance.
     */
    public function __construct(Product $product, $seriesProducts = [])
    {
        $this->product = $product;
        $this->seriesProducts = $seriesProducts;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.frontend.home.products.product-details', [
            'product' => $this->product,
            'seriesProducts' => $this->seriesProducts
        ]);
    }
}
