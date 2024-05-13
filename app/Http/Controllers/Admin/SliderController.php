<?php

namespace App\Http\Controllers\Admin;

use App\Models\Slider as MainMoDel;
use App\Http\Requests\SliderRequest as MainRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $this->save($request, ['task' => 'add-item']);
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

    // public function updateOrdering(Request $request)
    // {
    //     // Lấy danh sách ID:
    //     $ids = array_column($request->order, 'id');
    //     // Cập nhật hàng loạt:
    //     $updated = MainModel::whereIn('id', $ids)->update([
    //         // FIELD xác định vị trí (index) của mỗi id trong mảng $ids => cập nhật cho ordering
    //         // FIELD(id, 3, 1, 4): id = 3 có index = 2 => cập nhật ordering = 2
    //         //                     id = 1 có index = 1 => cập nhật ordering = 1
    //         //                     id = 3 có index = 3 => cập nhật ordering = 3
    //         'ordering' => DB::raw('FIELD(id, ' . implode(',', $ids) . ')'),
    //     ]);
    //     if ($updated !== count($ids)) {
    //         return response('Update failed.', 500);
    //     }
    //     return response('Update Successfully.', 200);
    // }

    public function updateOrdering(Request $request)
    {
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
