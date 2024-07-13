<?php

namespace App\View\Components\Frontend\Home\Products;

use App\Models\CategoryProducts;
use App\Models\Product;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Breadcrumb extends Component
{
    protected $categoryBreadcrumb;
    protected $product;
    /**
     * Create a new component instance.
     */
    public function __construct($categoryBreadcrumb, Product $product)
    {
        $this->categoryBreadcrumb = $categoryBreadcrumb;
        $this->product = $product;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.frontend.home.products.breadcrumb', [
            'categoryBreadcrumb' => $this->categoryBreadcrumb,
            'product' => $this->product
        ]);
    }
}
