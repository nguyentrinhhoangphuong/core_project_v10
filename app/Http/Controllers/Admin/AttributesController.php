<?php

namespace App\Http\Controllers\Admin;

use App\Models\Attributes as MainMoDel;
use App\Models\AttributeValue;
use Illuminate\Http\Request;

class AttributesController extends AdminController
{
    protected AttributeValue $attributeValues;
    public function __construct(MainMoDel $model, AttributeValue $attributeValues)
    {
        parent::__construct($model);
        $this->controllerName = 'attributes';
        $this->title = 'Danh sách thuộc tính';
        $this->routeName = 'attributes';
        $this->params['pagination']['totalItemsPerPage'] = 20;
        $this->pathViewController = 'admin.pages.product.' . $this->controllerName . '.';
        $this->routeIndex = 'admin.' . $this->routeName . '.index';
        view()->share('controllerName', $this->controllerName);
        view()->share('routeName', $this->routeName);
        view()->share('routeCreate', $this->routeCreate);
        $this->attributeValues = $attributeValues;
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
    public function create(Request $request)
    {
        $items = $this->attributeValues->where('attribute_id', $request->atrributeId)->get();
        $atrributeName = $request->atrributeName;
        $atrributeId = $request->atrributeId;
        return view($this->pathViewController . 'create', [
            'title' => ucfirst($this->title) . ': ' . $atrributeName,
            'items' => $items,
            'atrributeName' => $atrributeName,
            'atrributeId' => $atrributeId
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $item = MainMoDel::create($request->all());
        $count = MainMoDel::count();
        return response()->json([
            'success' => true,
            'item' => [
                'id' => $item->id,
                'count' => $count,
                'name' => $item->name,
                'routeName' => 'attributes',
                'deleteUrl' => route('admin.attributes.destroy', ['item' => $item->id]),
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
        return redirect()->route($this->routeIndex)->with('success', 'Đã xóa thành công');
    }
}
