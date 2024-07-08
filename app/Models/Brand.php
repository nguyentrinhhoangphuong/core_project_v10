<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Brand extends MainModel
{
    use HasFactory;
    public function __construct()
    {
        $this->fieldSearchAccepted = config('zvn.config.search')['brand'];
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'brand_id');
    }

    public function getProductCountAttribute()
    {
        return $this->products()->count();
    }

    public function baseQuery()
    {
        return self::from('brands as b');
    }

    public function listItems($params = null, $options = null)
    {
        $result = null;
        if ($options['task'] == 'admin-list-item') {
            $query = $this->baseQuery()->select('b.id', 'b.name');

            if (!empty($params['search']['value'])) {
                $searchValue = "%{$params['search']['value']}%";
                if ($params['search']['field'] == 'all') {
                    $query->where(function ($query) use ($searchValue) {
                        array_shift($this->fieldSearchAccepted); // bỏ all
                        foreach ($this->fieldSearchAccepted as $field) {
                            $query->orWhere('b.' . $field, 'LIKE', $searchValue);
                        }
                    });
                } else if (in_array($params['search']['field'], $this->fieldSearchAccepted)) {
                    $query->where('b.' . $params['search']['field'], 'LIKE', $searchValue);
                }
            }

            $result = $query->orderBy('b.id', 'desc')->paginate($params['pagination']['totalItemsPerPage']);
        }
        return $result;
    }
}
