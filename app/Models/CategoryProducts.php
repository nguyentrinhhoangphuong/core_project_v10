<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Kalnoy\Nestedset\NodeTrait;

class CategoryProducts extends MainModel
{
    use HasFactory, NodeTrait;

    public $fieldSearchAccepted = ['all', 'name'];

    public function categories()
    {
        return $this->hasMany(CategoryProducts::class, 'parent_id', 'id')->with('category_products');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'category_product_id');
    }

    public function getProductCountAttribute()
    {
        return $this->products()->count();
    }

    public function children()
    {
        return $this->hasMany(CategoryProducts::class, 'parent_id');
    }

    public function listItems($params = null, $options = null)
    {
        $result = null;
        if ($options['task'] == 'admin-list-item') {
            $query = self::select('id', 'name', 'description', 'status', 'parent_id', '_lft', '_rgt', 'created_at', 'updated_at');

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
            $result = self::select('id', 'name', 'parent_id', '_lft', '_rgt', 'status')->where('id', $params)->first();
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
            $parent = self::find($request['parent_id']);
            self::create($this->prepareParams($request), $parent);
        }

        if ($options['task'] == 'edit-item') {
            $params = $request->all();
            $parent = self::find($params['parent_id']);
            $node = $current = self::find($params['id']);
            $node->update($this->prepareParams($params));
            if ($current->parent_id != $params['parent_id']) {
                $node->appendToNode($parent)->save();
            }
        }
    }

    public function deleteItem($item)
    {
        $node = self::find($item['id']);
        $node->delete();
    }
}
