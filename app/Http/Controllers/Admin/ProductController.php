<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product as MainMoDel;
use App\Http\Requests\ProductsRequest as MainRequest;
use App\Models\Brand;
use App\Models\CategoryProducts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\FacadesLog;

class ProductController extends AdminController
{
    protected CategoryProducts $categoryProduct;
    protected Brand $brand;

    public function __construct(MainMoDel $model, CategoryProducts $categoryProduct, Brand $brand)
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
        $this->categoryProduct = $categoryProduct;
        $this->brand = $brand;
    }

    public function index(Request $request)
    {
        $params = $this->params; // Tạo một bản sao của $this->params
        $items = $this->getAllItems($params, $request);
        return view($this->pathViewController . 'index', [
            'params' => $params,
            'title' => 'Tất cả sản phẩm',
            'items' => $items,
        ]);
    }

    public function store(Request $request)
    {
        $this->save($request, ['task' => 'add-item']);
        return redirect()->route($this->routeIndex)->with('success', ucfirst($this->controllerName) . ' created successfully');
    }

    // tự động lưu vào file tạm sau khi kéo thả, thêm image 
    public function storeMedia(Request $request)
    {
        $path = public_path('_admin/temp/');
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        $files = $request->file('file');
        $arrImg = [];
        foreach ($files as $key => $file) {
            $nameFile = $file->getClientOriginalName();
            $file->move($path, $nameFile);
            $arrImg[] = $nameFile;
        }
        return response()->json([
            'original_name' => $arrImg,
        ]);
    }

    public function edit($item)
    {
        $item = $this->getSingleItem($item);
        $categoryProduct = $this->categoryProduct::withDepth()->defaultOrder()->get()->toFlatTree();
        $brands = $this->brand::all();
        return view($this->pathViewController . 'edit', [
            'title' => 'Edit ' . $this->controllerName,
            'item' => $item,
            'categoryProduct' => $categoryProduct,
            'brands' => $brands,
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
                'alt' => $file['custom_properties']['alt'] ?? "",
                'size' => $file['size'],
                'order' => $file['order_column'],
                'url' => $file->getUrl(),
            ];
        }
        return response()->json($items);
    }
    public function create()
    {
        $categoryProduct = $this->categoryProduct::withDepth()->defaultOrder()->get()->toFlatTree();
        $brands = $this->brand::all();
        return view($this->pathViewController . 'create', [
            'title' => 'Add ' . $this->controllerName,
            'categoryProduct' => $categoryProduct,
            'brands' => $brands,
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
        $product = MainMoDel::find($request->id);
        if ($product && in_array($request->field, ['status', 'is_top', 'is_featured'])) {
            $field = $request->field;
            $product->$field = $request->status;
            $product->save();
            return response()->json(['success' => true]);
        }
        return response()->json(['error' => 'Invalid field or item not found'], 400);
    }

    public function filterProduct(Request $request)
    {
        $items = $request->all();
        array_shift($items);
        $data = MainMoDel::getFilterProduct($items, ['task' => 'collection']);
        $html = view('admin.pages.' . $this->controllerName . '.list_row', ['items' => $data])->render();
        return response()->json(['success' => true, 'data' => $html]);
    }
}
