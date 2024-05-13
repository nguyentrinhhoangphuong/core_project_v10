<?php

namespace App\View\Components\Frontend\Footer;

use App\Models\Setting;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SubFooterConfig extends Component
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
        $itemsGeneral = $this->model->getItem('general-config', ['task' => 'get-item']);
        $itemsSocial = $this->model->getItem('social-config', ['task' => 'get-item']);
        return view('components.frontend.footer.sub-footer-config', compact('itemsGeneral', 'itemsSocial'));
    }
}
