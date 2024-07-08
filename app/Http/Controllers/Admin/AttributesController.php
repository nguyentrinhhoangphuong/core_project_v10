<?php

namespace App\Http\Controllers\Admin;

use App\Models\Attributes as MainMoDel;
use App\Models\AttributeValue;
use App\Models\ProductAttributes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AttributesController extends AdminController
{
    protected AttributeValue $attributeValues;
    protected ProductAttributes $productAttributes;
    public function __construct(MainMoDel $model, AttributeValue $attributeValues, ProductAttributes $productAttributes)
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
        $this->productAttributes = $productAttributes;
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
        $slug = Str::slug($request->name, '-');
        $request['ordering'] = MainModel::max('ordering') + 1;
        $data = $request->all();
        $data['slug'] = $slug;
        $item = MainMoDel::create($data);
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
        $counts = $this->productAttributes::where('attribute_id', $item->id)
            ->groupBy('product_id')
            ->select(DB::raw('count(*) as count'))
            ->get();
        $totalCount = $counts->sum('count');
        if ($totalCount > 0) {
            return redirect()->route($this->routeIndex)
                ->with('info', 'Không xóa được vì thuộc tính đang được ' . $totalCount . ' sản phẩm sử dụng');
        }
        $item->delete();
        return redirect()->route($this->routeIndex)->with('success', 'Đã xóa thành công');
    }

    public function updateStatus(Request $request)
    {
        $product = MainMoDel::find($request->id);
        $field = $request->field;
        $product->$field = $request->status;
        $product->save();
        return response()->json(['success' => true]);
    }

    public function updateOrdering(Request $request)
    {
        // dd($request->all());
        DB::beginTransaction(); // Bắt đầu giao dịch
        try {
            // Lấy danh sách ID:
            $ids = array_column($request->order, 'id');

            // Cập nhật hàng loạt:
            $updated = MainModel::whereIn('id', $ids)->update([
                'ordering' => DB::raw('FIELD(id, ' . implode(',', $ids) . ')'),
            ]);

            if ($updated !== count($ids)) {
                DB::rollBack(); // Quay lại trạng thái trước đó nếu cập nhật không thành công
                return response('Update failed.', 500);
            }

            DB::commit(); // Xác nhận giao dịch thành công
            return response('Update Successfully.', 200);
        } catch (\Exception $e) {
            DB::rollBack(); // Quay lại trạng thái trước đó nếu có lỗi xảy ra
            return response('An error occurred.', 500);
        }
    }
}
