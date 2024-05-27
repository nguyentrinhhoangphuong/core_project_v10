<?php

namespace App\Http\Controllers\Admin;

use App\Models\Setting as MainMoDel;
use App\Http\Requests\SettingRequest as MainRequest;
use Illuminate\Http\Request;

class SettingController extends AdminController
{
    protected $model;
    public function __construct(MainMoDel $model)
    {
        parent::__construct($model);
        $this->controllerName = 'setting';
        $this->routeName = 'settings';
        $this->params['pagination']['totalItemsPerPage'] = 5;
        $this->pathViewController = 'admin.pages.' . $this->controllerName . '.';
        $this->routeIndex = 'admin.' . $this->routeName . '.index';
        $this->routeCreate = $this->routeName . '/create';
        view()->share('controllerName', $this->controllerName);
        view()->share('routeName', $this->routeName);
        view()->share('routeCreate', $this->routeCreate);
        $this->model = $model;
    }

    public function index()
    {
        $items = $this->model->getAll();
        return view($this->pathViewController . 'index', [
            'items' => $items,
            'title' => ucfirst($this->controllerName) . 's Management',
        ]);
    }

    public function store(MainRequest $request)
    {
        $this->save($request, ['task' => 'add-item-social']);
        return redirect()->route($this->routeIndex)->with('success', ucfirst($this->controllerName) . ' created successfully');
    }

    // ================================ General Config ================================
    public function ajaxUpdateGeneralConfig(Request $request)
    {
        $this->save($request, ['task' => 'add-item-general']);
        return redirect()->route($this->routeIndex)->with('success', ucfirst($this->controllerName) . ' updated successfully');
    }

    // ================================ SOCIAL ===================================

    public function addSocialConfig()
    {
        return view($this->pathViewController . 'addSocialConfig', [
            'title' => ucfirst($this->controllerName) . 's Management',
        ]);
    }

    public function updateSocialConfig(Request $request)
    {
        $this->save($request->all(), ['task' => 'update-social-config']);
        return redirect()->route($this->routeIndex)->with('success', ucfirst($this->controllerName) . ' updated successfully');
    }

    public function ajaxUpdateSocialConfig(Request $request)
    {
        $getItems = $this->getSingleItem($request->keyValue);
        $this->save($request, ['task' => 'ajax-update-social-config', 'getItems' => $getItems]);
        return response()->json(['message' => 'Cập nhật thành công.']);
    }

    public function ajaxUpdateSocialPositions(Request $request)
    {
        $getItems = $this->getSingleItem($request->keyValue);
        $this->save($request, ['task' => 'ajax-update-social-positions', 'getItems' => $getItems]);
        return response()->json(['message' => 'Cập nhật thành công.']);
    }

    public function ajaxDeleteSocialConfig(Request $request)
    {
        $getItems = $this->getSingleItem($request->keyValue);
        $this->save($request, ['task' => 'ajax-delete-social-config', 'getItems' => $getItems]);
        return response()->json(['message' => 'Đã xóa thành công.']);
    }

    public function ajaxInsertSocialConfig(Request $request)
    {
        $getItems = $this->getSingleItem($request->keyValue);
        $this->save($request, ['task' => 'ajax-insert-social-config', 'getItems' => $getItems]);
        return response()->json(['message' => 'Đã thêm thành công.']);
    }

    public function ajaxUpdateOrdering(Request $request)
    {
        $getItems = $this->getSingleItem($request->order[0]['keyValue']);
        $this->save($request, ['task' => 'ajax-update-ordering-social-config', 'getItems' => $getItems]);
        return response()->json(['message' => 'Đã sắp xếp thành công.']);
    }

    // ================================== Useful Links ====================================

    public function usefulLinksConfigStore(Request $request)
    {
        $this->save($request, ['task' => 'add-item-useful-links']);
        return redirect()->route($this->routeIndex)->with('success', ucfirst($this->controllerName) . ' created successfully');
    }

    public function addUsefulLinksConfig()
    {
        return view($this->pathViewController . 'addUsefulLinksConfig', [
            'title' => ucfirst($this->controllerName) . 's Management',
        ]);
    }

    public function ajaxUpdateUsefulLinkOrdering(Request $request)
    {
        $getItems = $this->getSingleItem($request->order[0]['keyValue']);
        $this->save($request, ['task' => 'ajax-update-useful-link-ordering', 'getItems' => $getItems]);
        return response()->json(['message' => 'Đã sắp xếp thành công.']);
    }

    public function ajaxUpdateUsefulLinkField(Request $request)
    {
        $getItems = $this->getSingleItem($request->keyValue);
        $this->save($request, ['task' => 'ajax-update-useful-link-field', 'getItems' => $getItems]);
    }

    // =================================== Help Center ======================================
    public function helpCenterConfigStore(Request $request)
    {
        $this->save($request, ['task' => 'add-item-help-center']);
        return redirect()->route($this->routeIndex)->with('success', ucfirst($this->controllerName) . ' created successfully');
    }

    public function addHelpCenterConfig()
    {
        return view($this->pathViewController . 'addHelpCenterConfig', [
            'title' => ucfirst($this->controllerName) . 's Management',
        ]);
    }

    public function ajaxUpdateHelpCenterOrdering(Request $request)
    {
        $getItems = $this->getSingleItem($request->order[0]['keyValue']);
        $this->save($request, ['task' => 'ajax-update-help-center-ordering', 'getItems' => $getItems]);
        return response()->json(['message' => 'Đã sắp xếp thành công.']);
    }

    public function ajaxUpdateHelpCenterField(Request $request)
    {
        $getItems = $this->getSingleItem($request->keyValue);
        $this->save($request, ['task' => 'ajax-update-help-center-field', 'getItems' => $getItems]);
    }

    //===========================================================================
    public function ajaxDeleteItem(Request $request)
    {
        $getItems = $this->getSingleItem($request->keyValue);
        $this->save($request, ['task' => 'ajax-delete-item', 'getItems' => $getItems]);
        return response()->json(['message' => 'Đã xóa thành công.']);
    }
}
