<?php

namespace App\View\Components\Frontend\Home;

use App\Models\Product;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TopProducts extends Component
{
    protected $products;

    /**
     * Create a new component instance.
     */
    public function __construct(Product $products)
    {
        $this->products = $products->getTopProducts();
        // Xử lý thuộc tính của sản phẩm
        foreach ($this->products as $product) {
            $product->setAttribute('processed_attributes', $product->processAttributes());
        }
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.frontend.home.top-products', [
            'topProducts' => $this->products,
        ]);
    }
}
