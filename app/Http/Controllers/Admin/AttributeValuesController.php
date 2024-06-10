<?php

namespace App\Http\Controllers\Admin;

use App\Models\AttributeValue as MainMoDel;
use Illuminate\Http\Request;

class AttributeValuesController extends AdminController
{
    public function __construct(MainMoDel $model)
    {
        parent::__construct($model);
        $this->controllerName = 'attributeValues';
        $this->title = 'Chi tiết thuộc tính';
        $this->routeName = 'attribute-values';
        $this->params['pagination']['totalItemsPerPage'] = 10;
        $this->pathViewController = 'admin.pages.product.' . $this->controllerName . '.';
        $this->routeIndex = 'admin.' . $this->routeName . '.index';
        view()->share('controllerName', $this->controllerName);
        view()->share('routeName', $this->routeName);
        view()->share('routeCreate', $this->routeCreate);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $params = $this->params; // Tạo một bản sao của $this->params
        $items = $this->getAllItems($params, $request);
        return view($this->pathViewController . 'index', [
            'params' => $params,
            'title' => ucfirst($this->title),
            'items' => $items,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $item = MainMoDel::create($request->all());
        return response()->json([
            'success' => true,
            'item' => [
                'name' => $item->value,
                'deleteUrl' => route('admin.attribute-values.destroy', ['item' => $item->id]),
            ],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MainMoDel $item)
    {
        $item->delete();
        return redirect()->back()->with('success', 'Đã xóa thành công');
    }
}
