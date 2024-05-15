<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product as MainMoDel;
use App\Http\Requests\ProductsRequest as MainRequest;
use Illuminate\Http\Request;

class ProductController extends AdminController
{
    public function __construct(MainMoDel $model)
    {
        parent::__construct($model);
        $this->controllerName = 'product';
        $this->routeName = 'products';
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
            'title' => ucfirst($this->controllerName) . ' Management',
            'items' => $items,
        ]);
    }

    public function store(Request $request)
    {
        dd($request->all());
        $this->save($request, ['task' => 'add-item']);
        return redirect()->route($this->routeIndex)->with('success', ucfirst($this->controllerName) . ' created successfully');
    }



    public function upload()
    {
        $storeFolder = public_path('_admin/temp/');
        if (!file_exists($storeFolder) && !is_dir($storeFolder)) {
            mkdir($storeFolder);
        }
        if (!empty($_FILES)) {
            foreach ($_FILES['file']['tmp_name'] as $key => $value) {
                $tempFile = $_FILES['file']['tmp_name'][$key];
                $targetFile = $storeFolder . $_FILES['file']['name'][$key];
                move_uploaded_file($tempFile, $targetFile);
            }
        }
    }

    public function edit($item)
    {
        $item = $this->getSingleItem($item);
        return view($this->pathViewController . 'edit', [
            'title' => 'Edit ' . $this->controllerName,
            'item' => $item,
        ]);
    }

    public function files($id)
    {
        $item = MainMoDel::findOrFail($id);
        $files = $item['media'];
        $items = [];
        foreach ($files as $file) {
            $items[] = [
                'media_id' => $file['id'],
                'name' => $file['file_name'],
                'alt' => $file['custom_properties']['alt'],
                'size' => $file['size'],
                'order' => $file['order_column'],
                'url' => $file->getUrl(),
            ];
        }
        return response()->json($items);
    }
    public function create()
    {
        $items = [];
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
}
