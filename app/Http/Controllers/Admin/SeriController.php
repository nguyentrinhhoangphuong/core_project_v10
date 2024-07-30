<?php

namespace App\Http\Controllers\Admin;

use App\Models\Series as MainMoDel;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SeriController extends AdminController
{
    protected $brand;
    public function __construct(MainMoDel $model, Brand $brand)
    {
        parent::__construct($model);
        $this->controllerName = 'seri';
        $this->title = 'Danh sách các dòng sản phẩm';
        $this->routeName = 'seri';
        $this->params['pagination']['totalItemsPerPage'] = 10;
        $this->pathViewController = 'admin.pages.product.' . $this->controllerName . '.';
        $this->routeIndex = 'admin.' . $this->routeName . '.index';
        view()->share('controllerName', $this->controllerName);
        view()->share('routeName', $this->routeName);
        view()->share('routeCreate', $this->routeCreate);
        $this->brand = $brand;
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $brand = $this->brand->where('id', $request->brandId)->firstorFail();
        $items = MainMoDel::where('brand_id', $brand->id)->get();
        return view($this->pathViewController . 'create', [
            'title' => ucfirst($this->title),
            'brand' => $brand->name,
            'brandId' => $brand->id,
            'items' => $items,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $slug = Str::slug($request->name, '-');
        $data = $request->all();
        $data['slug'] = $slug;
        $item = MainMoDel::create($data);
        return response()->json([
            'success' => true,
            'item' => [
                'id' => $item->id,
                'name' => $item->name,
                'routeName' => 'series',
                'deleteUrl' => route('admin.series.destroy', ['item' => $item->id]),
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

    public function getSeriesByBrainId($brandId)
    {
        $series = MainMoDel::getSeriesByBrandId($brandId)->get(['id', 'name']);
        return response()->json($series);
    }
}
