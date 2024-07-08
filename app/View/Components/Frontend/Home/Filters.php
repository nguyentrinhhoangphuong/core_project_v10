<?php

namespace App\View\Components\Frontend\Home;

use App\Models\AttributeValue;
use App\Models\Brand;
use App\Models\CategoryProducts;
use App\Models\ProductAttributes;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Filters extends Component
{
    protected $brand;
    protected AttributeValue $attributeValue;
    /**
     * Create a new component instance.
     */
    public function __construct(Brand $brand, AttributeValue $attributeValue)
    {
        $this->brand = $brand::select('id', 'name')->get();
        $this->attributeValue = $attributeValue;
    }

    public function filterOptions()
    {
        return $this->attributeValue->getAttrFilterForFrontend();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.frontend.home.filters', [
            'brands' => $this->brand,
            'filterOptions' => $this->filterOptions(),
        ]);
    }
}
