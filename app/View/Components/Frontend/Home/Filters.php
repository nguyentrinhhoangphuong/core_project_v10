<?php

namespace App\View\Components\Frontend\Home;

use App\Models\AttributeValue;
use App\Models\Brand;
use App\Models\CategoryProducts;
use App\Models\ProductAttributes;
use App\Services\CategoryProductAttribute\CategoryProductAttributeService;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Filters extends Component
{
    public $brands;
    public $filterAttributes;
    public $filterSummary;
    protected $categoryProductAttributeService;


    /**
     * Create a new component instance.
     */
    public function __construct($brands, $filterAttributes, $filterSummary)
    {
        $this->brands = $brands;
        $this->filterAttributes = $filterAttributes;
        $this->filterSummary = $filterSummary;
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.frontend.home.filters', [
            'brands' => $this->brands,
            'filterAttributes' => $this->filterAttributes,
            'filterSummary' => $this->filterSummary,
        ]);
    }
}
