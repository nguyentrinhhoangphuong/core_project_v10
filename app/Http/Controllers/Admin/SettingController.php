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

    public function store(Request $request)
    {
        $task = '';
        if ($request['add-item-config'] === 'add-item-social') {
            $task = 'add-item-social';
        } elseif ($request['add-item-config'] === 'add-item-useful-links') {
            $task = 'add-item-useful-links';
        } elseif ($request['add-item-config'] === 'add-item-help-center') {
            $task = 'add-item-help-center';
        } else {
            $task = 'add-item-general';
        }
        $this->save($request->all(), ['task' => $task]);
        return redirect()->route($this->routeIndex)->with('success', ucfirst($this->controllerName) . ' created successfully');
    }

    // ===================================================================

    public function addSocialConfig()
    {
        return view($this->pathViewController . 'addSocialConfig', [
            'title' => ucfirst($this->controllerName) . 's Management',
        ]);
    }

    public function editSocialConfig(Request $request)
    {
        $getItems = $this->getSingleItem($request->key_value);
        $decodeItems = json_decode($getItems['value'], true);
        $items = NULL;
        foreach ($decodeItems as $item) {
            if ($item['id'] == $request->id) {
                $items = $item;
                $items['key_value'] = $request->key_value;
                break;
            }
        }
        if (!$items) {
            abort(404);
        }
        return view($this->pathViewController . 'editSocialConfig', [
            'items' => $items,
            'title' => ucfirst($this->controllerName) . 's Management',
        ]);
    }

    public function updateSocialConfig(Request $request)
    {
        $this->save($request->all(), ['task' => 'update-social-config']);
        return redirect()->route($this->routeIndex)->with('success', ucfirst($this->controllerName) . ' updated successfully');
    }

    // ======================================================================

    public function addUsefulLinksConfig()
    {
        return view($this->pathViewController . 'addUsefulLinksConfig', [
            'title' => ucfirst($this->controllerName) . 's Management',
        ]);
    }

    public function editUsefulLinksConfig(Request $request)
    {
        $getItems = $this->getSingleItem($request->key_value);
        $decodeItems = json_decode($getItems['value'], true);
        $items = NULL;
        foreach ($decodeItems as $item) {
            if ($item['id'] == $request->id) {
                $items = $item;
                $items['key_value'] = $request->key_value;
                break;
            }
        }
        if (!$items) {
            abort(404);
        }
        return view($this->pathViewController . 'editUsefulLinksConfig', [
            'items' => $items,
            'title' => ucfirst($this->controllerName) . 's Management',
        ]);
    }

    public function updateUsefulLinksConfig(Request $request)
    {
        $this->save($request->all(), ['task' => 'update-useful-links-config']);
        return redirect()->route($this->routeIndex)->with('success', ucfirst($this->controllerName) . ' updated successfully');
    }

    // =========================================================================
    public function addHelpCenterConfig()
    {
        return view($this->pathViewController . 'addHelpCenterConfig', [
            'title' => ucfirst($this->controllerName) . 's Management',
        ]);
    }

    public function editHelpCenterConfig(Request $request)
    {
        $getItems = $this->getSingleItem($request->key_value);
        $decodeItems = json_decode($getItems['value'], true);
        $items = NULL;
        foreach ($decodeItems as $item) {
            if ($item['id'] == $request->id) {
                $items = $item;
                $items['key_value'] = $request->key_value;
                break;
            }
        }
        if (!$items) {
            abort(404);
        }
        return view($this->pathViewController . 'editHelpCenterConfig', [
            'items' => $items,
            'title' => ucfirst($this->controllerName) . 's Management',
        ]);
    }

    public function updateHelpCenterConfig(Request $request)
    {
        $this->save($request->all(), ['task' => 'update-help-center-config']);
        return redirect()->route($this->routeIndex)->with('success', ucfirst($this->controllerName) . ' updated successfully');
    }
}
