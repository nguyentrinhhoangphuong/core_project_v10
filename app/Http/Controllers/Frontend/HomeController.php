<?php

namespace App\Http\Controllers\Frontend;

use App\Models\CategoryProducts;
use App\Models\Product;
use App\Models\ProductAttributes;
use Illuminate\Http\Request;

class HomeController extends FrontendController
{
    protected CategoryProducts $categoryProducts;
    protected Product $product;

    public function __construct(CategoryProducts $categoryProducts, Product $product)
    {
        $this->controllerName = 'home';
        $this->params['pagination']['totalItemsPerPage'] = 5;
        $this->pathViewController = 'frontend.pages.' . $this->controllerName . '.';
        view()->share('controllerName', $this->controllerName);
        $this->categoryProducts = $categoryProducts;
        $this->product = $product;
    }

    public function index()
    {

        return view('frontend.pages.home.index');
    }

    public function login()
    {
        return view('frontend.pages.home.login');
    }

    public function register()
    {
        return view('frontend.pages.home.register');
    }

    public function showProductbyCategory(Request $request, $slug)
    {
        $arrSlug = explode('-', $slug);
        $categoryProductID = $this->categoryProducts->descendantsAndSelf($arrSlug[count($arrSlug) - 1])->pluck('id');
        array_pop($arrSlug);
        $breadcrumb = implode(" ", $arrSlug);
        $productsQuery = Product::withRelations()
            ->inCategories($categoryProductID)
            ->select('id', 'name', 'price', 'original_price', 'is_featured', 'category_product_id', 'brand_id');

        if ($request->has('sort')) {
            $sort = $request->input('sort');
            $productsQuery->sortBy($sort);
        }
        $products = $productsQuery->paginate(3);
        return view($this->pathViewController . 'showProductbyCategory', compact('products', 'breadcrumb'));
    }

    public function filter(Request $request)
    {
        $brands = $request->input('brand', []);
        $filters = $request->input('filters', []);
        $products = Product::withRelations()
            ->select('id', 'name', 'price', 'original_price', 'category_product_id', 'brand_id')
            ->filterByBrands($brands)
            ->filterByAttributes($filters)
            ->paginate(3);
        $breadcrumb = "Tất cả sản phẩm";
        return view($this->pathViewController . 'showProductbyCategory', compact('products', 'breadcrumb'));
    }
}
