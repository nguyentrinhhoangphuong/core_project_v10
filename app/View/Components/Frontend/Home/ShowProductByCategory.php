<?php

namespace App\View\Components\Frontend\Home;

use App\Models\Product;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
// controller(khởi tạo product)->truyền sang components (đặt trên view-controller)(thực hiện setAttribute)-render view-component
class ShowProductByCategory extends Component
{
    protected $products;
    protected $requiredAttributes = ['cpu', 'ram', 'ssd'];

    /**
     * Create a new component instance.
     */
    public function __construct($products)
    {
        if ($products) {
            $this->products = $products;
            $this->products = $products->map(function ($product) {
                $product->setAttribute('processed_attributes', $product->processAttributes());
                return $product;
            });
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.frontend.home.show-product-by-category', [
            'productsComponent' => $this->products,
        ]);
    }
}
