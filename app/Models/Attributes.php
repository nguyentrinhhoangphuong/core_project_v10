<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attributes extends MainModel
{
    use HasFactory;
    public function __construct()
    {
        $this->fieldSearchAccepted = config('zvn.config.search')['attributes'];
    }

    public function attributeValue()
    {
        return $this->hasMany(AttributeValue::class, 'attribute_id');
    }

    // public function categoryProducts()
    // {
    //     return $this->belongsToMany(CategoryProducts::class, 'category_product_attributes', 'attribute_id', 'category_product_id');
    // }

    public function productAttributes()
    {
        return $this->hasMany(ProductAttributes::class, 'attribute_id');
    }

    public function baseQuery()
    {
        return self::from('attributes as a');
    }

    public function listItems($params = null, $options = null)
    {
        $result = null;
        if ($options['task'] == 'admin-list-item') {
            $query = $this->baseQuery()->select('a.id', 'a.name', 'a.slug', 'a.is_filter', 'a.ordering');

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

            $result = $query->orderBy('a.ordering')->paginate($params['pagination']['totalItemsPerPage']);
        }
        return $result;
    }
}
