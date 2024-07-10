<?php

namespace App\View\Components\Admin\Setting;

use App\Models\Setting;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class GeneralConfig extends Component
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
        $item = $this->model->getItem('general-config', ['task' => 'get-item']);
        return view('components.admin.setting.general-config', compact('item'));
    }
}