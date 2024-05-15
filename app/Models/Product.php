<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Product extends MainModel
{
    use HasFactory;

    public $fieldSearchAccepted = ['all', 'name'];


    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($product) {
            // Delete associated media
            $product->clearMediaCollection();
        });
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
            $result = self::select('id', 'name', 'price', 'description', 'content', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by')->where('id', $params)->first();
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
            $item = $request->all();
            $fileObj = $item['images'];
            $alts = $item['alt'];
            $images = $this->uploadFileMulty_dropzone($fileObj, $alts);
            $results = self::create($item);
            foreach ($images as $image) {
                $results->addMedia(public_path('_admin/temp/') . $image['image'])
                    ->withCustomProperties(['alt' => $image['alt']])
                    ->toMediaCollection();
            }
            $this->deleteFileTemp();
        }

        if ($options['task'] == 'edit-item') {
            $item = $request->all();
            $alts = $item['alt'];
            $resource = self::findOrFail($item['id']);
            $existingImages = $resource->media;
            // update alt
            foreach ($existingImages as $index => $image) {
                if (isset($alts[$index])) {
                    $alts[$index] = $alts[$index] ?? " ";
                    $image->setCustomProperty('alt', $alts[$index]);
                    $image->save();
                }
            }

            // Xóa bớt hình ảnh
            if ($existingImages->count() > count($item['images'])) {
                $deletedImageIndexes = array_diff(range(0, $existingImages->count()  - 1), array_keys($item['images']));

                foreach ($deletedImageIndexes as $deletedIndex) {
                    $existingImages[$deletedIndex]->delete();
                }
            }

            if ($existingImages->count() < count($item['images'])) {
                // Thêm hình ảnh mới
                foreach ($item['images'] as $index => $newImage) {
                    if (!isset($existingImages[$index])) {
                        // Tạo bản sao của hình ảnh trong thư mục tạm thời
                        $copiedFilePath = $this->copyImageToTempFolder(public_path('_admin/temp/') . $newImage);
                        $resource->addMedia($copiedFilePath)
                            ->withCustomProperties(['alt' => $alts[$index]])
                            ->toMediaCollection();
                    }
                }
            }

            // Đảm bảo thứ tự hình ảnh đúng theo mảng 'images'
            foreach ($item['images'] as $index => $imageName) {
                $mediaItem = $resource->media->firstWhere('file_name', $imageName);
                if ($mediaItem && $mediaItem->order_column !== $index) {
                    $mediaItem->order_column = $index;
                    $mediaItem->save();
                }
            }

            $resource->fill($item);
            $resource->save();
        }
    }

    // Hàm để tạo bản sao của hình ảnh trong thư mục tạm thời
    private function copyImageToTempFolder($filePath)
    {
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        $newFileName = uniqid() . '.' . $extension;
        $copiedFilePath = public_path('_admin/temp/') . $newFileName;
        copy($filePath, $copiedFilePath);
        return $copiedFilePath;
    }

    public function uploadFileMulty_dropzone($fileObj, $alts)
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


    private function randomFileName($fileName, $length = 9)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        $extension = '.' . pathinfo($fileName, PATHINFO_EXTENSION);
        return $randomString . $extension;
    }

    public function deleteItem($params = null, $options = null)
    {
        if ($options['task'] == 'delete-item') {
            $this->find($params->id)->delete();
        }
    }
}
