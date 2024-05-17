<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MainModel extends Model implements HasMedia
{

    use InteractsWithMedia;

    protected $folderUpload = '';
    protected $fieldSearchAccepted = [];
    protected $crudNotAccepted = ['_token', '_method', 'thumb_current', 'add-item-config'];
    protected $guarded = ['_token', '_method', 'thumb_current', 'add-item-config'];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->width(300)->height(300);
        $this->addMediaConversion('webp')->format('webp')->performOnCollections('images');
    }

    //  zvn_storage_image: nằm trong config/filesystems để cài đặt path cho hình
    public function uploadThumb($thumbObj)
    {
        $thumbName = Str::random(10) . '.' . $thumbObj->extension();
        $thumbObj->storeAs($this->folderUpload, $thumbName, 'zvn_storage_image');
        return $thumbName;
    }

    public function getThumbName($thumbObj)
    {
        $thumbName = Str::random(10) . '.' . $thumbObj->extension();
        return $thumbName;
    }

    public function deleteThumb($thumbName)
    {
        Storage::disk('zvn_storage_image')->delete($this->folderUpload . '/' . $thumbName);
    }

    public function prepareParams($params)
    {
        // dùng array_flip($this->crudNotAccepted) chuyển value->key. 
        // sau đó array_diff_key sẽ loại bỏ những phần tử của $params nào có value giống với key của array_flip
        return array_diff_key($params, array_flip($this->crudNotAccepted));
    }
}
