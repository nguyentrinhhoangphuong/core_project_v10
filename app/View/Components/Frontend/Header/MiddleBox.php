<?php

namespace App\View\Components\Frontend\Header;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MiddleBox extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.frontend.header.middle-box');
    }
}
