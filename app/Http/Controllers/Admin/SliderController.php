<?php

namespace App\Http\Controllers\Admin;

use App\Models\Slider as MainMoDel;
use App\Http\Requests\SliderRequest as MainRequest;
use Illuminate\Http\Request;

class SliderController extends AdminController
{
    public function __construct(MainMoDel $model)
    {
        parent::__construct($model);
        $this->controllerName = 'slider';
        $this->routeName = 'sliders';
        $this->params['pagination']['totalItemsPerPage'] = 5;
        $this->pathViewController = 'admin.pages.' . $this->controllerName . '.';
        $this->routeIndex = 'admin.' . $this->routeName . '.index';
        $this->routeCreate = $this->routeName . '/create';
        view()->share('controllerName', $this->controllerName);
        view()->share('routeName', $this->routeName);
        view()->share('routeCreate', $this->routeCreate);
    }

    public function index(Request $request)
    {
        $params = $this->params; // Tạo một bản sao của $this->params
        $items = $this->getAllItems($params, $request);
        return view($this->pathViewController . 'index', [
            'params' => $params,
            'title' => ucfirst($this->controllerName) . 's Management',
            'items' => $items,
        ]);
    }

    public function store(MainRequest $request)
    {
        $this->save($request);
        return redirect()->route($this->routeIndex)->with('success', ucfirst($this->controllerName) . ' created successfully');
    }

    public function edit($item)
    {
        $result = $this->getSingleItem($item);
        return view($this->pathViewController . 'edit', [
            'title' => 'Edit ' . $this->controllerName,
            'item' => $result,
        ]);
    }

    public function create()
    {
        return view($this->pathViewController . 'create', [
            'title' => 'Add ' . $this->controllerName
        ]);
    }

    public function update(MainRequest $request, MainMoDel $item)
    {
        $this->updateItem($request, $item);
        return redirect()->route($this->routeIndex)->with('success', ucfirst($this->controllerName) . ' updated successfully');
    }

    public function destroy(MainMoDel $item)
    {
        $this->deleteItem($item);
        return redirect()->route($this->routeIndex)->with('success', ucfirst($this->controllerName) . ' deleted successfully');
    }

    public function updateStatus(Request $request)
    {
        $category = MainMoDel::find($request->id);
        $category->status = $request->status;
        $category->save();
        return response()->json([
            'success' => true,
            'data' => [
                'active' => config('zvn.template.status.active.name'),
                'inactive' => config('zvn.template.status.inactive.name')
            ]
        ]);
    }
}
