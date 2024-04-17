<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;

class DashboardController extends AdminController
{
    public function __construct()
    {
        view()->share('controllerName', $this->controllerName);
        $this->controllerName = 'dashboard';
        $this->pathViewController = 'admin.pages.dashboard.';
    }

    public function index()
    {
        return view($this->pathViewController . 'index', [
            'title' =>  'Dashboard'
        ]);
    }
}
