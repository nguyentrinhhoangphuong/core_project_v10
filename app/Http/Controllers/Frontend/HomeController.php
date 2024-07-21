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
        $this->numberOfPage = 12;
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
        if ($categoryProductID->isEmpty()) {
            abort(404);
        }
        array_pop($arrSlug);
        $breadcrumb = implode(" ", $arrSlug);
        $productsQuery = Product::withRelations()
            ->inCategories($categoryProductID)
            ->select('id', 'name', 'price', 'original_price', 'is_featured', 'category_product_id', 'brand_id');

        if ($request->has('sort')) {
            $sort = $request->input('sort');
            $productsQuery->sortBy($sort);
        }
        $products = $productsQuery->paginate($this->numberOfPage);
        // Kiểm tra xem có sản phẩm nào không
        return view($this->pathViewController . 'showProductbyCategory', compact('products', 'breadcrumb'));
    }

    public function filter(Request $request)
    {
        $brands = $request->input('brand', []);
        if (!is_array($brands)) $brands = [$brands];
        $filters = $request->input('filters', []);
        // Kiểm tra nếu filters không phải là một mảng, chuyển đổi thành mảng với giá trị đó
        if (!is_array($filters))  $filters = [$filters];

        $sort = $request->input('sort');
        $products = Product::withRelations()
            ->select('id', 'name', 'price', 'is_featured', 'original_price', 'category_product_id', 'brand_id')
            ->filterByBrands($brands)
            ->filterByAttributes($filters)
            ->sortBy($sort)
            ->paginate($this->numberOfPage);
        $breadcrumb = "Tất cả sản phẩm";
        return view($this->pathViewController . 'showProductbyCategory', compact('products', 'breadcrumb'));
    }

    public function productDetails($slug)
    {
        $arrSlug = explode('-', $slug);
        $productId = array_pop($arrSlug);
        $product = $this->product->getProductDetailsById($productId);
        $trendingProducts = $this->product->getTopProducts(5);
        $relatedProducts = $this->product->getRelatedProductsByBrand($productId, $product->brand_id, 10);
        $categoryBreadcrumb = $this->categoryProducts->ancestorsAndSelf($product->category_product_id);
        $attributes = [];
        foreach ($product->productAttributes as $attribute) {
            if ($attribute->attribute && $attribute->attributeValue) {
                $attributes[$attribute->attribute->name] = $attribute->attributeValue->value;
            }
        }
        return view('frontend.pages.home.productDetails', [
            'product' => $product,
            'attributes' => $attributes,
            'trendingProducts' => $trendingProducts,
            'relatedProducts' => $relatedProducts,
            'categoryBreadcrumb' => array_slice($categoryBreadcrumb->toArray(), -2),
        ]);
    }
}
