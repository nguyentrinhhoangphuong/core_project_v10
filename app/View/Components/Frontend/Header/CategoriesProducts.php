<?php

namespace App\View\Components\Frontend\Header;

use App\Models\CategoryProducts;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CategoriesProducts extends Component
{
    protected $model;
    /**
     * Create a new component instance.
     */
    public function __construct(CategoryProducts $model)
    {
        $this->model = $model;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $categories = $this->model->getMainCategories();
        return view('components.frontend.header.categories-products', compact('categories'));
    }
}
