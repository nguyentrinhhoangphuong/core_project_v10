<?php

namespace App\Http\Controllers\Admin;

use App\Models\Article as MainMoDel;
use App\Http\Requests\ArticleRequest as MainRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class ArticleController extends AdminController
{
    protected $categoryModel;

    public function __construct(MainMoDel $model, Category $categoryModel)
    {
        parent::__construct($model);
        $this->controllerName = 'article';
        $this->routeName = 'articles';
        $this->params['pagination']['totalItemsPerPage'] = 5;
        $this->pathViewController = 'admin.pages.' . $this->controllerName . '.';
        $this->routeIndex = 'admin.' . $this->routeName . '.index';
        $this->routeCreate = $this->routeName . '/create';
        view()->share('controllerName', $this->controllerName);
        view()->share('routeName', $this->routeName);
        view()->share('routeCreate', $this->routeCreate);
        $this->categoryModel = $categoryModel;
    }

    public function index(Request $request)
    {
        $params = $this->params; // Tạo một bản sao của $this->params
        $items = $this->getAllItems($params, $request);
        $itemsCategory = $this->categoryModel->listItems($this->params, ['task' => 'admin-list-items-in-selectbox']);
        return view($this->pathViewController . 'index', [
            'params' => $params,
            'title' => ucfirst($this->controllerName) . 's Management',
            'items' => $items,
            'itemsCategory' => $itemsCategory,
        ]);
    }


    public function store(MainRequest $request)
    {
        $this->save($request->all());
        return redirect()->route($this->routeIndex)->with('success', ucfirst($this->controllerName) . ' created successfully');
    }

    public function edit($item)
    {
        $result = $this->getSingleItem($item);
        $itemsCategory = $this->categoryModel->listItems($this->params, ['task' => 'admin-list-items-in-selectbox']);
        return view($this->pathViewController . 'edit', [
            'title' => 'Edit ' . $this->controllerName,
            'item' => $result,
            'itemsCategory' => $itemsCategory,

        ]);
    }

    public function create()
    {
        $itemsCategory = $this->categoryModel->listItems($this->params, ['task' => 'admin-list-items-in-selectbox']);
        return view($this->pathViewController . 'create', [
            'title' => 'Add ' . $this->controllerName,
            'itemsCategory' => $itemsCategory,
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
        return response()->json(['success' => true, 'message' => ucfirst($this->controllerName) . ' deleted successfully']);
    }

    public function updateStatus(Request $request)
    {
        $sts = MainMoDel::find($request->id);
        $sts->status = $request->status;
        $sts->save();
        return response()->json([
            'success' => true,
            'data' => [
                'active' => config('zvn.template.status.active.name'),
                'inactive' => config('zvn.template.status.inactive.name')
            ]
        ]);
    }

    public function updateCategory(Request $request)
    {
        $category = MainMoDel::find($request->id);
        $category->category_id = $request->category_id;
        $category->save();
        return response()->json([
            'success' => true,
        ]);
    }
}
