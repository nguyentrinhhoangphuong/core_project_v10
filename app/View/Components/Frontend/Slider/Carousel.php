<?php

namespace App\View\Components\Frontend\Slider;

use App\Models\Slider;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Carousel extends Component
{
    protected $model;
    /**
     * Create a new component instance.
     */
    public function __construct(Slider $model)
    {
        $this->model = $model;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $items = $this->model->all();
        return view('components.frontend.slider.carousel', compact('items'));
    }
}
