<?php

namespace App\View\Components\Admin\Products;

use App\Models\Attributes;
use App\Models\AttributeValue;
use App\Models\Brand;
use App\Models\ProductAttributes;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Filter extends Component
{
    protected Brand $brand;
    protected AttributeValue $attributeValue;
    protected ProductAttributes $productAttributes;
    /**
     * Create a new component instance.
     */
    public function __construct(Brand $brand, AttributeValue $attributeValue, ProductAttributes $productAttributes)
    {
        $this->brand = $brand;
        $this->attributeValue = $attributeValue;
        $this->productAttributes = $productAttributes;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $brands = $this->brand->all();
        $attribute = Attributes::with('attributeValue')->get();
        return view('components.admin.products.filter', compact('brands', 'attribute'));
    }
}
