<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class AttributeValue extends MainModel
{
    use HasFactory;

    public function attribute()
    {
        return $this->belongsTo(Attributes::class, 'attribute_id');
    }

    public function getAttrFilterForFrontend()
    {
        $filterOptions = DB::table('attributes as a')
            ->join('attribute_values as av', 'av.attribute_id', '=', 'a.id')
            ->where('a.is_filter', 1)
            ->select('a.name', 'av.value', 'av.id as value_id')
            ->get()
            ->groupBy('name');
        return $filterOptions;
    }
}
