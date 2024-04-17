<?php

namespace App\View\Components\Admin\Forms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Label extends Component
{
    public $testAbc = "asdjskd";
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        // $this->testAbc = "sdhjkhjkdads";
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.forms.label');
    }
}
