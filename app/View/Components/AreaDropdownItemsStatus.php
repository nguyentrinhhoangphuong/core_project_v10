<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AreaDropdownItemsStatus extends Component
{
    public $buttonName = 'Lọc trạng thái';
    public $tmplStatus;

    /**
     * Create a new component instance.
     */
    public function __construct(public $params, public $routeName)
    {
        $this->tmplStatus = config('zvn.template.status');
    }

    public function getLi()
    {
        $li = '';

        $filterStatus = isset($params['filter']['status']) ? $params['filter']['status'] : null;

        foreach ($this->tmplStatus as $key => $value) {
            $link = route('admin.' . $this->routeName . '.index') . '?filter_status=' . $key;
            $class = $value['class'];
            $name = $value['name'];

            // Kiểm tra xem trạng thái có trùng khớp với giá trị đã chọn không
            $this->buttonName = $filterStatus === $key ? $this->tmplStatus[$key]['name'] : $this->buttonName;

            $li .= sprintf('<li><a class="%s" href="%s">%s</a></li>', $class, $link, $name);
        }

        return $li;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.admin.area-dropdown-items-status');
    }
}
