<?php

namespace App\Models;

use App\Helpers\Template;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;


class Product extends MainModel
{
    use HasFactory;

    public $fieldSearchAccepted = ['all', 'name'];
    public $requiredAttributes = ['cpu', 'ram', 'ssd'];

    // một sản phẩm (Product) có thể có nhiều thuộc tính sản phẩm (ProductAttribute).
    public function productAttributes()
    {
        return $this->hasMany(ProductAttributes::class);
    }

    public function categoryProduct()
    {
        return $this->belongsTo(CategoryProducts::class, 'category_product_id');
    }

    public function brandProduct()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function listItems($params = null, $options = null)
    {
        $result = null;
        if ($options['task'] == 'admin-list-item') {
            $query = self::with('categoryProduct')->select('id', 'name', 'is_top', 'is_featured', 'category_product_id', 'price', 'description', 'content', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by');

            if ($params['filter']['status'] != 'all') {
                $query->where('status', $params['filter']['status']);
            }

            if (!empty($params['search']['value'])) {
                $searchValue = "%{$params['search']['value']}%";
                if ($params['search']['field'] == 'all') {
                    $query->where(function ($query) use ($searchValue) {
                        array_shift($this->fieldSearchAccepted); // bỏ all
                        foreach ($this->fieldSearchAccepted as $field) {
                            $query->orWhere($field, 'LIKE', $searchValue);
                        }
                    });
                } else if (in_array($params['search']['field'], $this->fieldSearchAccepted)) {
                    $query->where($params['search']['field'], 'LIKE', $searchValue);
                }
            }

            $result = $query->orderBy('id', 'desc')->get();
        }

        if ($options['task'] == 'admin-list-items-in-selectbox') {
            $query = self::select('id', 'name')->where('parent_id', '>', 0)->orderBy('name', 'asc');
            $result = $query->pluck('name', 'id')->toArray();
        }

        return $result;
    }

    public function getItem($params = null, $options = null)
    {
        $result = null;
        if ($options['task'] == 'get-item') {
            $result = self::select('id', 'name', 'is_top', 'is_featured', 'status', 'price', 'brand_id', 'original_price', 'is_top', 'slug', 'qty', 'description', 'content', 'created_at', 'updated_at', 'seo_title', 'seo_description')->where('id', $params)->first();
        }
        return $result;
    }


    public function countItems($params = null, $options = null)
    {
        $result = null;
        if ($options['task'] === 'admin-count-items-group-by-status') {
            $query = self::query();
            if (!empty($params['search']['value'])) {
                $searchValue = "%{$params['search']['value']}%";
                if ($params['search']['field'] === 'all') {
                    $query->where(function ($query) use ($searchValue) {
                        foreach ($this->fieldSearchAccepted as $field) {
                            $query->orWhere($field, 'LIKE', $searchValue);
                        }
                    });
                } else if (in_array($params['search']['field'], $this->fieldSearchAccepted)) {
                    $query->where($params['search']['field'], 'LIKE', $searchValue);
                }
            }
            $result = $query->select('status', DB::raw('COUNT(id) as count'))->groupBy('status')->get()->toArray();
        }
        return $result;
    }


    public function saveItem($request, $options)
    {
        if ($options['task'] == 'add-item') {
            $item = self::create($request->all());

            $alts = $request->input('alt', []);
            $images = $request->input('images', []);

            foreach ($images as $index => $file) {
                if (file_exists(public_path('_admin/temp/' . $file))) {
                    $item->addMedia(public_path('_admin/temp/' . $file))
                        ->withCustomProperties(['alt' => $alts[$index] ?? ''])
                        ->toMediaCollection();
                }
            }
            return redirect()->route('admin.products.index');
        }

        if ($options['task'] == 'edit-item') {
            $item = self::find($request->input('id'));
            if (!isset($item)) {
                return redirect()->route('admin.products.index')->withErrors('Project not found.');
            }

            $item->update($request->all());

            $image_delete = $request->input('image_delete', []);
            $images = $request->input('images', []);
            $alts = $request->input('alt', []);
            $mediaItems = $item->getMedia();
            foreach ($images as $index => $file) {
                if (isset($alts[$index])) {
                    $mediaItem = $mediaItems->firstWhere('file_name', $file);
                    if ($mediaItem) {
                        $mediaItem->setCustomProperty('alt', $alts[$index]);
                        $mediaItem->save();
                    }
                }
            }

            if (count($image_delete) > 0) {
                foreach ($mediaItems as $media) {
                    // Kiểm tra xem $media->file_name này có trong danh sách $image_delete cần xóa không
                    if (in_array($media->file_name, $image_delete)) {
                        $media->delete();
                    }
                }
            }


            if (count($images) > 0) {
                foreach ($images as $index => $file) {
                    if (file_exists(public_path('_admin/temp/' . $file))) {
                        $item->addMedia(public_path('_admin/temp/' . $file))
                            ->withCustomProperties(['alt' => $alts[$index] ?? ''])
                            ->toMediaCollection();
                    }
                }
            }

            foreach ($images as $index => $item) {
                $mediaItem = $mediaItems->firstWhere('file_name', $item);
                if ($mediaItem && $mediaItem->order_column !== $index) {
                    $mediaItem->order_column = $index;
                    $mediaItem->save();
                }
            }
        }
    }

    public function assignAlttoImg($fileObj, $alts)
    {
        $arrImage = [];
        for ($i = 0; $i < count($fileObj); $i++) {
            $tempFilePath = public_path('_admin/temp/') . $fileObj[$i];
            if (file_exists($tempFilePath)) {
                $arrImage[$i]['image'] = $fileObj[$i];
                $arrImage[$i]['alt'] = !empty($alts[$i]) ? $alts[$i] : '';
            }
        }
        return $arrImage;
    }

    public function deleteFileTemp()
    {
        // Đường dẫn đầy đủ tới thư mục temp
        $tempDirectory = public_path('_admin/temp');
        // Sử dụng đường dẫn đầy đủ để lấy danh sách các file
        $files = glob($tempDirectory . '/*');
        // Xóa tất cả các file trong một lần sử dụng array_map
        array_map('unlink', $files);
    }

    public function deleteItem($params = null, $options = null)
    {
        if ($options['task'] == 'delete-item') {
            $this->find($params->id)->delete();
        }
    }

    public static function getFilterProduct($items,  $options = null)
    {
        $brandId = isset($items['brand']) ? $items['brand'] : null;
        unset($items['brand']);

        $attributeValueIds = array_filter($items, function ($value) {
            return ($value !== null && $value !== '');
        });
        $ids = array_values($attributeValueIds);
        $ids = Template::flattenArray($ids);

        $query = self::with(['productAttributes.attribute', 'productAttributes.attributeValue', 'categoryProduct']);
        $query->select('id', 'name', 'status', 'is_top', 'category_product_id', 'price', 'original_price', 'is_featured');

        // Thêm điều kiện lọc theo brand_id nếu brandId không rỗng
        if (!is_null($brandId)) {
            $query->whereIn('brand_id', $brandId);
        }
        // Thêm điều kiện lọc theo attribute_value_id nếu attributeValueIds không rỗng
        if (!empty($ids)) {
            $query->whereHas('productAttributes', function ($q) use ($ids) {
                $q->whereIn('attribute_value_id', $ids);
            });
        }

        if (isset($options['task']) && $options['task'] == 'collection') {
            return new Collection($query->get());
        }
    }

    public function scopeWithRelations(Builder $query)
    {
        return $query->with(['productAttributes.attribute', 'productAttributes.attributeValue', 'categoryProduct', 'brandProduct']);
    }

    public function scopeInCategories(Builder $query, $categoryProductID)
    {
        return $query->whereIn('category_product_id', $categoryProductID);
    }

    public function scopeSortBy(Builder $query, $sort)
    {
        switch ($sort) {
            case 'price-asc':
                return $query->orderBy('price', 'asc');
            case 'price-desc':
                return $query->orderBy('price', 'desc');
            case 'featured':
                return $query->where('is_featured', 1);
            case 'top':
                return $query->where('is_top', 1);
            default:
                return $query;
        }
    }

    public function scopeFilterByBrands(Builder $query, $brands)
    {
        if (!empty($brands)) {
            return $query->whereIn('brand_id', $brands);
        }
        return $query;
    }

    public function scopeFilterByAttributes(Builder $query, $filters)
    {
        foreach ($filters as $attribute => $attributeValuesId) {
            $attributeValuesId = (array) $attributeValuesId;
            $query->whereHas('productAttributes', function ($q) use ($attributeValuesId) {
                $q->whereIn('attribute_value_id', $attributeValuesId);
            });
        }
        return $query;
    }

    public function scopeGetTopProducts(Builder $query, $num = 8)
    {
        return self::where('is_top', 1)->paginate($num);
    }

    public function scopeGetFeaturedProducts()
    {
        return self::where('is_featured', 1)->paginate(8);
    }

    public function processAttributes()
    {
        $processedAttributes = [];
        foreach ($this->requiredAttributes as $requiredAttribute) {
            foreach ($this->productAttributes as $attribute) {
                if ($attribute->attribute && $attribute->attributeValue) {
                    if ($attribute->attribute->slug === $requiredAttribute) {
                        $attributeName = $attribute->attribute->name;
                        $attributeValue = $attribute->attributeValue->value;

                        $found = false;
                        foreach ($processedAttributes as &$processedAttribute) {
                            if ($processedAttribute['attribute_name'] === $attributeName) {
                                $processedAttribute['attribute_values'][] = $attributeValue;
                                $found = true;
                                break;
                            }
                        }

                        if (!$found) {
                            $processedAttributes[] = [
                                'attribute_name' => $attributeName,
                                'attribute_values' => [$attributeValue],
                            ];
                        }
                    }
                }
            }
        }

        return $processedAttributes;
    }

    public static function scopeGetProductByBrainId(Brand $id)
    {
        self::where('brand_id', $id)->paginate(8);
    }

    public function scopeGetProductDetailsById(Builder $query, $id)
    {
        $product = $query->with(['productAttributes.attribute', 'productAttributes.attributeValue'])
            ->where('id', $id)
            ->firstOrFail();
        return $product;
    }

    public function scopeGetRelatedProductsByBrand(Builder $query, $id, $brandId, $num = 10)
    {
        return self::where('brand_id', $brandId)
            ->where('id', '<>', $id)
            ->paginate($num);
    }
}
