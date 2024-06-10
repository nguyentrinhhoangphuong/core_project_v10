<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'App\\Http\\Controllers\\Admin\\'], function () {
    // ======================= Home ===============================
    Route::resource('dashboard', 'DashboardController');
    // ======================= SLIDER ===============================
    Route::post('sliders/update-status/{id}', ['uses' => 'SliderController@updateStatus', 'as' => 'sliders.update.status']);
    Route::post('sliders/update-ordering', ['uses' => 'SliderController@updateOrdering', 'as' => 'sliders.update.ordering']);
    Route::post('sliders/update-field', ['uses' => 'SliderController@updateField', 'as' => 'sliders.update.field']);
    Route::resource('sliders', 'SliderController', ['parameters' => ['sliders' => 'item']]);
    // ======================= CATEGORY =================================
    Route::get('categories/test', ['uses' => 'CategoryController@test']); // phải đứng trước resource
    Route::post('categories/update-status/{id}', ['uses' => 'CategoryController@updateStatus', 'as' => 'categories.update.status']);
    Route::get('categories/move/{id}/{type}', ['uses' => 'CategoryController@move', 'as' => 'categories.move']);
    Route::post('categories/updateTree', ['uses' => 'CategoryController@updateTree', 'as' => 'categories.update.tree']);
    Route::resource('categories', 'CategoryController', ['parameters' => ['categories' => 'item']]);
    // ======================= CATEGORY PRODUCT =================================
    Route::post('category-products/update-status/{id}', ['uses' => 'CategoryProductsController@updateStatus', 'as' => 'category-products.update.status']);
    Route::post('category-products/updateTree', ['uses' => 'CategoryProductsController@updateTree', 'as' => 'category-products.update.tree']);
    Route::resource('category-products', 'CategoryProductsController', ['parameters' => ['category-products' => 'item']]);
    // ======================= PRODUCT =================================
    // Route::post('products/update-status/{id}', ['uses' => 'ProductController@updateStatus', 'as' => 'products.update.status']);
    Route::post('products/upload', ['uses' => 'ProductController@upload', 'as' => 'products.upload']);
    Route::post('products/media', ['uses' => 'ProductController@storeMedia', 'as' => 'products.storeMedia']);
    Route::get('products/{id}/files', ['uses' => 'ProductController@files', 'as' => 'products.files']);
    Route::post('products/update-field', ['uses' => 'ProductController@updateField', 'as' => 'products.update.field']);
    Route::resource('products', 'ProductController', ['parameters' => ['products' => 'item']]);
    // ======================= MENUS =================================
    Route::post('menus/updateTree', ['uses' => 'MenuController@updateTree', 'as' => 'menus.update.tree']);
    Route::post('menus/addCustomLink', ['uses' => 'MenuController@addCustomLink', 'as' => 'menus.add.custom.link']);
    Route::resource('menus', 'MenuController', ['parameters' => ['menus' => 'item']]);
    // ======================= ARTICLE =================================
    Route::post('articles/update-status/{id}', ['uses' => 'ArticleController@updateStatus', 'as' => 'articles.update.status']);
    Route::post('articles/update-category/{id}', ['uses' => 'ArticleController@updateCategory', 'as' => 'articles.update.category']);
    Route::resource('articles', 'ArticleController', ['parameters' => ['articles' => 'item']]);
    // ======================= SETTING =================================
    // General Config
    Route::post('settings/ajax-update-general-config', ['uses' => 'SettingController@ajaxUpdateGeneralConfig', 'as' => 'settings.ajax.update.general.config']);

    // help center
    Route::get('settings/add-help-center-config', ['uses' => 'SettingController@addHelpCenterConfig', 'as' => 'settings.add.help.center.config']);
    Route::post('settings/help-center-config-store', ['uses' => 'SettingController@helpCenterConfigStore', 'as' => 'settings.add.help.center.config.store']);
    Route::post('settings/ajax-update-help-center-ordering', ['uses' => 'SettingController@ajaxUpdateHelpCenterOrdering', 'as' => 'settings.ajax.update.help.center.ordering']);
    Route::post('settings/ajax-update-help-center-field', ['uses' => 'SettingController@ajaxUpdateHelpCenterField', 'as' => 'settings.ajax.update.help.center.field']);

    // useful link
    Route::get('settings/add-useful-links-config', ['uses' => 'SettingController@addUsefulLinksConfig', 'as' => 'settings.add.useful.links.config']);
    Route::post('settings/useful-links-config-store', ['uses' => 'SettingController@usefulLinksConfigStore', 'as' => 'settings.add.useful.links.config.store']);
    Route::post('settings/ajax-update-useful-link-ordering', ['uses' => 'SettingController@ajaxUpdateUsefulLinkOrdering', 'as' => 'settings.ajax.update.useful.link.ordering']);
    Route::post('settings/ajax-update-useful-link-field', ['uses' => 'SettingController@ajaxUpdateUsefulLinkField', 'as' => 'settings.ajax.update.useful.link.field']);

    // social
    Route::post('settings/update-social-config', ['uses' => 'SettingController@updateSocialConfig', 'as' => 'settings.update.social.config']);
    Route::get('settings/edit-social-config/{id}', ['uses' => 'SettingController@editSocialConfig', 'as' => 'settings.edit.social.config']);
    Route::get('settings/add-social-config', ['uses' => 'SettingController@addSocialConfig', 'as' => 'settings.add.social.config']);
    Route::post('settings/ajax-update-social-config/{id}', ['uses' => 'SettingController@ajaxUpdateSocialConfig', 'as' => 'settings.ajax.update.social.config']);
    Route::post('settings/ajax-update-social-position/{id}', ['uses' => 'SettingController@ajaxUpdateSocialPositions', 'as' => 'settings.ajax.update.social.positions']);
    Route::delete('settings/ajax-delete-social-config/{id}', ['uses' => 'SettingController@ajaxDeleteSocialConfig', 'as' => 'settings.ajax.delete.social.config']);
    Route::post('settings/ajax-insert-social-config', ['uses' => 'SettingController@ajaxInsertSocialConfig', 'as' => 'settings.ajax.insert.social.config']);
    Route::post('settings/update-ordering', ['uses' => 'SettingController@ajaxUpdateOrdering', 'as' => 'settings.ajax.update.ordering']);

    Route::delete('settings/ajax-delete-item', ['uses' => 'SettingController@ajaxDeleteItem', 'as' => 'settings.ajax.delete.item']);
    Route::resource('settings', 'SettingController', ['parameters' => ['settings' => 'item']]);
    // ===================================== ATTRIBUTE ==================================
    Route::post('attributes/update-field', ['uses' => 'AttributesController@updateField', 'as' => 'attributes.update.field']);
    Route::resource('attributes', 'AttributesController', ['parameters' => ['attributes' => 'item']]);
    // ===================================== ATTRIBUTE VALUE ==================================
    Route::post('attribute-values/update-field', ['uses' => 'AttributeValuesController@updateField', 'as' => 'attribute.values.update.field']);
    Route::resource('attribute-values', 'AttributeValuesController', ['parameters' => ['attribute-values' => 'item']]);
    // ===================================== PRODUCT ATTRIBUTES ==================================
    Route::post('product-attributes/get-attribute-value-by-id', ['uses' => 'ProductAttributesController@getAttributeValueById', 'as' => 'product.attributes.getAttributeValueById']);
    Route::resource('product-attributes', 'ProductAttributesController', ['parameters' => ['product-attributes' => 'item']]);
    // ===================================== BRAND ==================================
    Route::post('brand/update-field', ['uses' => 'BrandController@updateField', 'as' => 'brand.update.field']);
    Route::resource('brand', 'BrandController', ['parameters' => ['brand' => 'item']]);

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


Route::post('/session/delete', function (Request $request) {
    $request->session()->forget($request->key);
});
