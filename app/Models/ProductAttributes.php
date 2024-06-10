<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class ProductAttributes extends MainModel
{
    use HasFactory;

    public static function getAttrValueById($id)
    {
        $results = DB::table('attribute_values as av')
            ->join('attributes as a', 'a.id', '=', 'av.attribute_id')
            ->select('av.id as attribute_value_id', 'av.value as attributeValues')
            ->where('a.id', $id)
            ->get();
        return $results;
    }

    public function saveItem($request, $options)
    {
        if ($options['task'] == 'add-item') {
            $data = $request->all();
            foreach ($data['attribute_value_id'] as $attribute_value_id) {
                self::insert([
                    'product_id' => $data['product_id'],
                    'attribute_id' => $data['attribute_id'],
                    'attribute_value_id' => $attribute_value_id,
                ]);
            }
        }
    }

    public static function getAttrForProduct($id)
    {
        $productAttributes = self::where('product_id', $id)
            ->join('attributes', 'product_attributes.attribute_id', '=', 'attributes.id')
            ->join('attribute_values', 'product_attributes.attribute_value_id', '=', 'attribute_values.id')
            ->select('product_attributes.id as product_attributes_id', 'attributes.id', 'attributes.name', 'attribute_values.value')
            ->get();
        return $productAttributes;
    }

    public static function checkAndSaveAttributes($request)
    {
        // Lấy tất cả các thuộc tính hiện tại của sản phẩm
        $existingAttributes = self::where('product_id', $request->product_id)
            ->where('attribute_id', $request->attribute_id)
            ->pluck('attribute_value_id')
            ->toArray();

        // Lọc các thuộc tính chưa tồn tại
        $newAttributeValues = array_filter($request->attribute_value_id, function ($valueId) use ($existingAttributes) {
            return !in_array($valueId, $existingAttributes);
        });

        foreach ($newAttributeValues as $valueId) {
            self::create([
                'product_id' => $request->product_id,
                'attribute_id' => $request->attribute_id,
                'attribute_value_id' => $valueId,
            ]);
        }
    }
}
