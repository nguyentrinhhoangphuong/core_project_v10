<?php

namespace App\View\Components\Frontend\Home\Products;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class RelatedProduct extends Component
{
    protected $relatedProducts;
    /**
     * Create a new component instance.
     */
    public function __construct($relatedProducts)
    {
        $this->relatedProducts = $relatedProducts;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.frontend.home.products.related-product', [
            'relatedProducts' => $this->relatedProducts
        ]);
    }
}
