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
    public $request;
    public $filterAttributes;
    public $filterSummary;
    public $slug;
    protected $categoryProductAttributeService;


    /**
     * Create a new component instance.
     */
    public function __construct($brands, $filterAttributes, $filterSummary, $request, $slug)
    {
        $this->brands = $brands;
        $this->request = $request;
        $this->slug = $slug;
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
            'request' => $this->request,
            'filterAttributes' => $this->filterAttributes,
            'filterSummary' => $this->filterSummary,
            'slug' => $this->slug,
        ]);
    }
}
