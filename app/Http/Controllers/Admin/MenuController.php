<?php

namespace App\Http\Controllers\Admin;

use App\Models\Menu as MainMoDel;
// use App\Http\Requests\MenuRequest as MainRequest;
use App\Models\Category;
use App\Models\CategoryProducts;
use Illuminate\Http\Request;

class MenuController extends AdminController
{
    protected $categoryModel;
    protected $categoryProductsModel;

    public function __construct(MainMoDel $model, Category $categoryModel, CategoryProducts $categoryProductsModel)
    {
        parent::__construct($model);
        $this->controllerName = 'menu';
        $this->routeName = 'menus';
        $this->params['pagination']['totalItemsPerPage'] = 5;
        $this->pathViewController = 'admin.pages.' . $this->controllerName . '.';
        $this->routeIndex = 'admin.' . $this->routeName . '.index';
        $this->routeCreate = $this->routeName . '/create';
        view()->share('controllerName', $this->controllerName);
        view()->share('routeName', $this->routeName);
        view()->share('routeCreate', $this->routeCreate);
        $this->categoryModel = $categoryModel;
        $this->categoryProductsModel = $categoryProductsModel;
    }

    public function index(Request $request)
    {
        // return MainMoDel::fixTree();
        $params = $this->params; // Tạo một bản sao của $this->params
        $items = MainModel::withDepth()->having('depth', '>', 0)->defaultOrder()->get()->toTree();
        $itemsCategory = $this->categoryModel::withDepth()->having('depth', '>', 0)->defaultOrder()->get()->toTree();
        $itemsCategoryProducts = $this->categoryProductsModel::withDepth()->having('depth', '>', 0)->defaultOrder()->get()->toTree();

        return view($this->pathViewController . 'index', [
            'params' => $params,
            'title' => ucfirst($this->controllerName) . 's Management',
            'items' => $items,
            'itemsCategory' => $itemsCategory,
            'itemsCategoryProducts' => $itemsCategoryProducts,
        ]);
    }

    public function store(Request $request)
    {
        $this->save($request->all(), ['task' => 'add-item']);
        $items = MainModel::withDepth()->having('depth', '>', 0)->defaultOrder()->get()->toTree();
        return view($this->pathViewController . 'list', compact('items'));
        // return response()->json([
        //     'success' => true,
        //     'items' => [
        //         'selectedValues' => $request['selectedValues'],
        //         'categoryModelType' => $request['categoryModelType'],
        //     ]
        // ]);
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


    public function updateTree(Request $request)
    {
        $data = $request->data;
        $root = MainModel::find(1);
        MainModel::rebuildSubtree($root, $data);
        // return view($this->pathViewController . 'list', compact('items'));
    }

    public function addCustomLink(Request $request)
    {
        $this->save($request, ['task' => 'add-custom-link']);
        return redirect()->route($this->routeIndex)->with('success', ucfirst($this->controllerName) . 'successfully');
    }
}
