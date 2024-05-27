<?php

namespace App\View\Components\Frontend\Header;

use App\Models\Setting;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Logo extends Component
{
    protected $model;
    /**
     * Create a new component instance.
     */
    public function __construct(Setting $model)
    {
        $this->model = $model;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $items = $this->model->getAll();
        return view('components.frontend.header.logo', compact('items'));
    }
}
