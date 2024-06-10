<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProductAttributesRequest as MainRequest;
use App\Models\Attributes;
use App\Models\ProductAttributes as MainMoDel;
use Illuminate\Http\Request;

class ProductAttributesController extends AdminController
{
    protected Attributes $attributes;
    public function __construct(MainMoDel $model, Attributes $attributes)
    {
        parent::__construct($model);
        $this->controllerName = 'productAttributes';
        $this->routeName = 'product-attributes';
        $this->title = 'Danh sách thuộc tính';
        $this->params['pagination']['totalItemsPerPage'] = 5;
        $this->pathViewController = 'admin.pages.product.' . $this->controllerName . '.';
        $this->routeIndex = 'admin.' . $this->routeName . '.index';
        $this->routeCreate = $this->routeName . '/create';
        view()->share('controllerName', $this->controllerName);
        view()->share('routeName', $this->routeName);
        view()->share('routeCreate', $this->routeCreate);
        $this->attributes = $attributes;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $productId = $request->productId;
        $items = MainMoDel::getAttrForProduct($productId);
        $groupedItems = $items->groupBy('name');
        $attributes = $this->attributes::select('id', 'name')->get();
        return view($this->pathViewController . 'index', [
            'groupedItems' => $groupedItems,
            'attributes' => $attributes,
            'title' => $this->title . ': ' . $request->productName,
            'productId' => $productId
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
    public function store(MainRequest $request)
    {
        MainMoDel::checkAndSaveAttributes($request);
        return redirect()->back()->with('success', 'Đã thêm thành công');
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

    public function getAttributeValueById(Request $request)
    {
        $attributeValues = MainMoDel::getAttrValueById($request->attributeId);
        return response()->json($attributeValues);
    }
}
