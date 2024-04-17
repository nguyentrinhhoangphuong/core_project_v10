<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;


class Slider extends MainModel
{
    use HasFactory;

    public function __construct()
    {
        $this->folderUpload = 'slider';
        $this->fieldSearchAccepted = config('zvn.config.search')['slider'];
    }

    public function listItems($params = null, $options = null)
    {
        $result = null;
        if ($options['task'] == 'admin-list-item') {
            $query = self::select('id', 'name', 'description', 'link', 'thumb', 'created_by', 'created_at', 'updated_at', 'updated_by', 'status');

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
            foreach ($result as $item) {
                $item->media = $item->getMedia('slider');
                foreach ($item->media as $media) {
                    $media->url = $media->getUrl();
                    $media->path = $media->getPath();
                }
            }
        }
        return $result;
    }


    public function getItem($params = null, $options = null)
    {
        $result = null;
        if ($options['task'] == 'get-item') {
            $result = self::select('id', 'name', 'description', 'status', 'link', 'thumb')->where('id', $params)->first();
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
            $item->addMediaFromRequest('thumb')->toMediaCollection($this->folderUpload);
        }

        if ($options['task'] == 'edit-item') {
            $params = $request->all();
            $item = $options['item'];
            if (!empty($params['thumb'])) {
                $item->clearMediaCollection($this->folderUpload);
                $item->addMediaFromRequest('thumb')->usingName($item->name)->toMediaCollection($this->folderUpload);
            }
            $item->fill($params);
            $item->save();
        }
    }

    public function deleteItem($params = null, $options = null)
    {
        if ($options['task'] == 'delete-item') {
            $params->clearMediaCollection($this->folderUpload);
            $params->delete();
        }
    }
}
