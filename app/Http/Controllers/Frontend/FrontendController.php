<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
  protected $model;
  protected $title;
  protected $pathViewController;
  protected $controllerName;
  protected $routeIndex;
  protected $routeName;
  protected $routeCreate;
  protected $params = [];
}
