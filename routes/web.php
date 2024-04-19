<?php

use App\Http\Controllers\Admin\FileManagerController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'App\\Http\\Controllers\\Admin\\'], function () {
    // ======================= Home ===============================
    Route::resource('dashboard', 'DashboardController');
    // ======================= SLIDER ===============================
    Route::post('sliders/update-status/{id}', ['uses' => 'SliderController@updateStatus', 'as' => 'sliders.update.status']);
    Route::resource('sliders', 'SliderController', ['parameters' => ['sliders' => 'item']]);
    // ======================= CATEGORY =================================
    Route::get('categories/test', ['uses' => 'CategoryController@test']); // phải đứng trước resource
    Route::post('categories/update-status/{id}', ['uses' => 'CategoryController@updateStatus', 'as' => 'categories.update.status']);
    Route::get('categories/move/{id}/{type}', ['uses' => 'CategoryController@move', 'as' => 'categories.move']);
    Route::post('categories/updateTree', ['uses' => 'CategoryController@updateTree', 'as' => 'categories.update.tree']);
    Route::resource('categories', 'CategoryController', ['parameters' => ['categories' => 'item']]);
    // ======================= ARTICLE =================================
    Route::post('articles/update-status/{id}', ['uses' => 'ArticleController@updateStatus', 'as' => 'articles.update.status']);
    Route::post('articles/update-category/{id}', ['uses' => 'ArticleController@updateCategory', 'as' => 'articles.update.category']);
    Route::resource('articles', 'ArticleController', ['parameters' => ['articles' => 'item']]);
    // ======================= laravel-filemanager ===================
    Route::get('filemanager', ['uses' => 'FileManagerController@index', 'as' => 'fileManager.index']);
});

Route::group(['prefix' => 'laravel-filemanager'], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});




Route::group(['prefix' => '', 'as' => '', 'namespace' => 'App\\Http\\Controllers\\Frontend\\'], function () {
    // ======================= Home ===============================
    Route::get('login', ['uses' => 'HomeController@login', 'as' => 'login']);
    Route::get('register', ['uses' => 'HomeController@register', 'as' => 'register']);
    Route::get('/', ['uses' => 'HomeController@index', 'as' => 'home.index']);
    Route::resource('home', 'HomeController');
});
