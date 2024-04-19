<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category as MainMoDel;
use App\Http\Requests\CategoryRequest as MainRequest;
use Illuminate\Http\Request;

class CategoryController extends AdminController
{
    public function __construct(MainMoDel $model)
    {
        parent::__construct($model);
        $this->controllerName = 'category';
        $this->routeName = 'categories';
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
        // $items = MainModel::withDepth()->having('depth', '>', 0)->defaultOrder()->get()->toFlatTree();
        return view($this->pathViewController . 'index', [
            'params' => $params,
            'title' => ucfirst($this->controllerName) . 's Management',
            'items' => $items,
        ]);
    }

    public function test(Request $request)
    {
        $params = $this->params; // Tạo một bản sao của $this->params
        $items = MainMoDel::whereNull('parent_id')->with('categories')->get();
        return view($this->pathViewController . 'category_test', [
            'params' => $params,
            'title' => ucfirst($this->controllerName) . 's Management',
            'items' => $items,
        ]);
    }

    public function store(MainRequest $request)
    {
        // $this->save($request->all());
        $this->save($request->all());
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

    public function move(Request $request)
    {
        $id = $request->id;
        $type = $request->type;
        $node = MainMoDel::find($id);
        $test = null;
        if ($type == 'up') {
            $test = $node->up();
        } else {
            $test = $node->down();
        }
        return redirect()->back();
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
        $root = MainModel::find(92);
        MainModel::rebuildSubtree($root, $data);
        return response()->json([
            'success' => true
        ]);
    }
}
