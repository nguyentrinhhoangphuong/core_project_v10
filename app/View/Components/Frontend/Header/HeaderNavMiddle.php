<?php

namespace App\View\Components\Frontend\Header;

use App\Models\Menu;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class HeaderNavMiddle extends Component
{
    protected $menuModel;
    /**
     * Create a new component instance.
     */
    public function __construct(Menu $menuModel)
    {
        $this->menuModel = $menuModel;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $items = $this->menuModel->withDepth()->where('parent_id', '>', 0)->defaultOrder()->get()->toTree();
        return view('components.frontend.header.HeaderNavMiddle', compact('items'));
    }
}
