<?php

namespace App\Http\Controllers\Admin;

use App\Models\CategoryProducts as MainMoDel;
// use App\Http\Requests\CategoryProductsRequest as MainRequest;
use Illuminate\Http\Request;

class CategoryProductsController extends AdminController
{
    public function __construct(MainMoDel $model)
    {
        parent::__construct($model);
        $this->controllerName = 'categoryProducts';
        $this->routeName = 'category-products';
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
        // return MainMoDel::fixTree();
        $params = $this->params; // Tạo một bản sao của $this->params
        $items = MainModel::withDepth()->having('depth', '>', 0)->defaultOrder()->get()->toTree();
        return view($this->pathViewController . 'index', [
            'params' => $params,
            'title' => ucfirst($this->controllerName) . ' Management',
            'items' => $items,
        ]);
    }

    public function store(Request $request)
    {
        $this->save($request->all(), ['task' => 'add-item']);
        return redirect()->route($this->routeIndex)->with('success', ucfirst($this->controllerName) . ' created successfully');
    }

    public function edit($item)
    {
        $result = $this->getSingleItem($item);
        $categories = MainModel::withDepth()->defaultOrder()
            ->where('_lft', '<', $result->_lft)
            ->orWhere('_lft', '>', $result->_rgt)
            ->get()
            ->toFlatTree();
        return view($this->pathViewController . 'edit', [
            'title' => 'Edit ' . $this->controllerName,
            'item' => $result,
            'categories' => $categories,
        ]);
    }

    public function create()
    {
        $items = MainMoDel::withDepth()->defaultOrder()->get()->toFlatTree();
        return view($this->pathViewController . 'create', [
            'title' => 'Add ' . $this->controllerName,
            'items' => $items,
        ]);
    }

    public function update(Request $request, MainMoDel $item)
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

    public function updateTree(Request $request)
    {
        $data = $request->data;
        $root = MainModel::find(1);
        MainModel::rebuildSubtree($root, $data);
        return response()->json([
            'success' => true
        ]);
    }
}
