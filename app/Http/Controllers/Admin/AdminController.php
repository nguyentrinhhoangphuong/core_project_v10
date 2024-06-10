<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    protected $model;
    protected $title;
    protected $pathViewController;
    protected $controllerName;
    protected $routeIndex;
    protected $routeName;
    protected $routeCreate;
    protected $params = [];

    public function __construct($model)
    {
        $this->model = new $model;
    }

    public function updateField(Request $request)
    {
        $fieldName = $request->fieldName;
        $newValue = $request->value;
        $itemId = $request->itemId;

        $this->model::where('id', $itemId)->update([
            $fieldName => $newValue,
        ]);
        return response()->json([
            'success' => true,
        ]);
    }

    public function getAllItems(&$params, $request)
    {
        $params['filter']['status'] = $request->input('filter_status', 'all');
        $params['search']['field'] = $request->input('search_field', '');
        $params['search']['value'] = $request->input('search_value', '');

        return $this->model->listItems($params, ['task' => 'admin-list-item']);
    }

    public function getSingleItem($item)
    {
        $result = $this->model->getItem($item, ['task' => 'get-item']);
        if ($result == null) return abort(404);
        return $result;
    }


    public function save($item, $options)
    {
        $this->model->saveItem($item, $options);
    }

    public function updateItem($request, $item)
    {
        if (!$item) return abort(404);
        $this->model->saveItem($request, ['task' => 'edit-item', 'item' => $item]);
    }

    public function countItem($params)
    {
        $this->model->countItems($params, ['task' => 'admin-count-items-group-by-status']);
    }

    public function show($item)
    {
        $result = $this->model->findOrFail($item);
        return $result;
    }

    public function deleteItem($item)
    {
        $this->model->deleteItem($item, ['task' => 'delete-item']);
    }
}
