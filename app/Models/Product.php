<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Product extends MainModel
{
    use HasFactory;

    public $fieldSearchAccepted = ['all', 'name'];

    // protected static function boot()
    // {
    //     parent::boot();
    //     static::deleting(function ($product) {
    //         // Delete associated media
    //         $product->clearMediaCollection();
    //     });
    // }

    // // Định nghĩa mối quan hệ một-nhiều với ProductVariant
    // public function variants()
    // {
    //     return $this->hasMany(ProductVariant::class, 'product_id', 'id');
    // }

    public function categoryProduct()
    {
        return $this->belongsTo(CategoryProducts::class, 'category_product_id');
    }

    public function listItems($params = null, $options = null)
    {
        $result = null;
        if ($options['task'] == 'admin-list-item') {
            $query = self::select('id', 'name', 'price', 'description', 'content', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by');

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
            $result = self::select('id', 'name', 'status', 'price', 'brand_id', 'category_product_id', 'original_price', 'is_top', 'is_featured', 'slug', 'qty', 'description', 'content', 'status', 'created_at', 'updated_at', 'seo_title', 'seo_description')->where('id', $params)->first();
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
}
