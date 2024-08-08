<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Attributes;
use App\Models\AttributeValue;
use App\Models\Brand;
use App\Models\CategoryProducts;
use App\Models\Product;
use App\Models\ProductAttributes;
use App\Services\CategoryProductAttribute\CategoryProductAttributeService;
use App\Services\WishList\WishListService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class HomeController extends FrontendController
{
    protected CategoryProducts $categoryProducts;
    protected Product $product;
    protected $wishListService;
    protected $categoryProductAttributeService;

    public function __construct(CategoryProducts $categoryProducts, Product $product, WishListService $wishListService, CategoryProductAttributeService $categoryProductAttributeService)
    {
        $this->controllerName = 'home';
        $this->numberOfPage = 12;
        $this->params['pagination']['totalItemsPerPage'] = 5;
        $this->pathViewController = 'frontend.pages.' . $this->controllerName . '.';
        view()->share('controllerName', $this->controllerName);
        $this->categoryProducts = $categoryProducts;
        $this->product = $product;
        $this->wishListService = $wishListService;
        $this->categoryProductAttributeService = $categoryProductAttributeService;
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

        $productsInSeries = $this->product->getProductsBySeries($product->series_id);
        $desiredKeys = ['CPU', 'Ram', 'SSD', 'Kích thước màn hình'];
        foreach ($productsInSeries as $productInSeries) {
            $attributes = [];
            foreach ($productInSeries->productAttributes as $attribute) {
                if ($attribute->attribute && $attribute->attributeValue) {
                    $attributes[$attribute->attribute->name] = $attribute->attributeValue->value;
                }
            }
            $filteredAttributes = array_intersect_key($attributes, array_flip($desiredKeys));
            $attributeString = implode(' + ', $filteredAttributes);
            $seriesProducts[] = [
                'productId' => $productInSeries->id,
                'productName' => $productInSeries->name,
                'attributeString' => $attributeString,
                'price' => $productInSeries->price,
                'series' => $productInSeries->series->name ?? ""
            ];
        }

        return view('frontend.pages.home.productDetails', [
            'product' => $product,
            'attributes' => $attributes,
            'trendingProducts' => $trendingProducts,
            'relatedProducts' => $relatedProducts,
            'categoryBreadcrumb' => array_slice($categoryBreadcrumb->toArray(), -2),
            'seriesProducts' => $seriesProducts
        ]);
    }

    public function wishList(Request $request)
    {
        $wishListID = json_decode(Cookie::get('wishlist'));
        $products = $this->wishListService->getProductWithList($wishListID);
        $breadcrumb = "Danh sách yêu thích";
        return view($this->pathViewController . 'wishList', compact('products', 'breadcrumb'));
    }

    public function addToWishList(Request $request)
    {
        $productId = $request->product_id;
        $this->wishListService->addToWithList($productId);
        $wishlistCount = $this->wishListService->countProducts() + 1;
        return response()->json(['success' => true, 'wishlistCount' => $wishlistCount, 'message' => 'Đã lưu sản phẩm vào danh sách yêu thích'], 201);
    }

    public function removeFromWishList($productId)
    {
        $this->wishListService->removeFromWishList($productId);
        $wishlistCount = $this->wishListService->countProducts() - 1;
        return response()->json([
            'success' => true,
            'message' => 'Đã xóa sản phẩm khỏi danh sách yêu thích',
            'wishlistCount' => $wishlistCount
        ]);
    }


    public function showProducts(Request $request, $slug = null)
    {
        $products = [];
        if ($slug === null) {
            // Xử lý cho trường hợp filterandsearch
            $valueSearch = $request->input('search') ?? "tất cả";
            $products = $this->product->filterAndSearch($request);
            if ($products->items() == []) {
                abort(404);
            };
            $breadcrumb = "Tìm kiếm: " . $valueSearch;
            $categoryProductID = null;
        } else {
            // Xử lý cho trường hợp showProductbyCategory
            $arrSlug = explode('-', $slug);
            $categoryProductsID = $this->categoryProducts->descendantsAndSelf($arrSlug[count($arrSlug) - 1])->pluck('id');
            if ($categoryProductsID->isEmpty()) {
                abort(404);
            }
            $categoryProductID = end($arrSlug);
            array_pop($arrSlug);
            $breadcrumb = implode(" ", $arrSlug);
            $productsQuery = Product::withRelations()
                ->inCategories($categoryProductsID)
                ->select('id', 'name', 'price', 'original_price', 'is_featured', 'category_product_id', 'brand_id');

            if ($request->has('sort')) {
                $sort = $request->input('sort');
                $productsQuery->sortBy($sort);
            }
            $products = $productsQuery->paginate($this->numberOfPage);
            $brandid = $products[0]['brand_id'];
            $brandname = $products[0]->brandProduct['name'];
            $brandIds = $products->pluck('brand_id')->unique()->toArray();
        }

        $filterAttributes = $this->categoryProductAttributeService->getRelevantFilterAttributes($products);
        $brands = $this->categoryProductAttributeService->getRelevantBrands($products);

        $filterSummary = [];
        if ($request->filters) {
            foreach ($request->filters as $attributeId => $values) {
                $attributeValues = AttributeValue::where('id', $values)->get();
                if (!empty($attributeValues)) {
                    foreach ($attributeValues as $value) {
                        $filterSummary[] = [
                            'type' => 'attribute',
                            'id' => $value->id,
                            'value' => $value->value,
                        ];
                    }
                }
            }
        }
        if ($request->brand) {
            $brands  = Brand::whereIn('id', $request->brand)->get();
            foreach ($brands as $brand) {
                $filterSummary[] = [
                    'type' => 'brand',
                    'id' => $brand->id,
                    'value' => $brand->name,
                ];
            }
        }

        return view($this->pathViewController . 'showProductbyCategory', compact('products', 'breadcrumb', 'filterAttributes', 'brands', 'categoryProductID', 'filterSummary', 'request'));
    }

    public function clearAllFilters(Request $request)
    {
        $currentUrl = url()->previous();
        $url = parse_url($currentUrl);
        if (isset($url['query'])) {
            unset($url['query']);
        }
        return redirect()->route('frontend.home.showProducts');
    }

    public function removeFilter(Request $request, $type, $id)
    {
        $currentUrl = url()->previous();
        $url = parse_url($currentUrl);
        $queryParams = [];
        if (isset($url['query'])) {
            parse_str($url['query'], $queryParams);
        }
        if ($type === 'attribute' && isset($queryParams['filters'][$id])) {
            unset($queryParams['filters'][$id]);
            if (empty($queryParams['filters'])) {
                unset($queryParams['filters']);
            }
        } elseif ($type === 'brand' && isset($queryParams['brand'])) {
            $brandIndex = array_search($id, $queryParams['brand']);
            unset($queryParams['brand'][$brandIndex]);
        }
        $newUrl = $url['scheme'] . '://' . $url['host'] . ':' . $url['port']  . $url['path'];
        if (!empty($queryParams)) {
            $newUrl .= '?' . http_build_query($queryParams);
            return redirect($newUrl);
        }
        return redirect()->route('frontend.home.showProducts');
    }
}
