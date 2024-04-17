<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Article extends MainModel
{
    use HasFactory;
    public function __construct()
    {
        $this->folderUpload = 'article';
        $this->fieldSearchAccepted = config('zvn.config.search')['article'];
    }

    public function baseQuery()
    {
        return self::from('articles as a');
    }

    public function listItems($params = null, $options = null)
    {
        $result = null;
        if ($options['task'] == 'admin-list-item') {
            $query = $this->baseQuery()->select('a.id', 'a.title', 'a.content', 'a.thumb', 'a.created_by', 'a.created_at', 'a.updated_at', 'a.updated_by', 'a.status', 'c.name as category_name', 'c.id as category_id')
                ->leftJoin('categories as c', 'c.id', '=', 'a.category_id');

            if ($params['filter']['status'] != 'all') {
                $query->where('a.status', $params['filter']['status']);
            }

            if (!empty($params['search']['value'])) {
                $searchValue = "%{$params['search']['value']}%";
                if ($params['search']['field'] == 'all') {
                    $query->where(function ($query) use ($searchValue) {
                        array_shift($this->fieldSearchAccepted); // bỏ all
                        foreach ($this->fieldSearchAccepted as $field) {
                            $query->orWhere('a.' . $field, 'LIKE', $searchValue);
                        }
                    });
                } else if (in_array($params['search']['field'], $this->fieldSearchAccepted)) {
                    $query->where('a.' . $params['search']['field'], 'LIKE', $searchValue);
                }
            }

            $result = $query->orderBy('a.id', 'desc')->paginate($params['pagination']['totalItemsPerPage']);
        }


        return $result;
    }

    public function getItem($params = null, $options = null)
    {
        $result = null;
        if ($options['task'] == 'get-item') {
            $result = $this->baseQuery()->select('a.id', 'a.title', 'a.content', 'a.status', 'a.thumb', 'c.id as category_id')
                ->join('categories as c', 'a.category_id', '=', 'c.id')
                ->where('a.id', $params)
                ->first();
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
            // $request['thumb'] = $this->uploadThumb($request['thumb']);
            // self::create($request);
            $item = self::create($request);
            $item->addMediaFromRequest('thumb')->toMediaCollection($this->folderUpload);
        }

        if ($options['task'] == 'edit-item') {
            $params = $request->all();
            $item = $options['item'];
            if (!empty($params['thumb'])) {
                $item->clearMediaCollection($this->folderUpload);
                $item->addMediaFromRequest('thumb')->toMediaCollection($this->folderUpload);
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
