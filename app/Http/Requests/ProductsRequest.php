<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Hoặc logic xác thực quyền truy cập của bạn
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'original_price' => 'required|numeric|min:0',
            'category_product_id' => 'required|exists:category_products,id',
            'brand_id' => 'required|exists:brands,id',
            'description' => 'nullable|string',
            'series_id' => 'nullable|exists:series,id',
            'sku' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'status' => 'nullable|boolean',
            'slug' => 'nullable|string|max:255|unique:products,slug,' . $this->id,
            'qty' => 'nullable|integer|min:0',
            'offer_start_date' => 'nullable|date',
            'offer_end_date' => 'nullable|date|after_or_equal:offer_start_date',
            'is_top' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Tên sản phẩm là bắt buộc.',
            'price.required' => 'Giá sản phẩm là bắt buộc.',
            'original_price.required' => 'Giá gốc sản phẩm là bắt buộc.',
            'category_product_id.required' => 'Danh mục sản phẩm là bắt buộc.',
            'brand_id.required' => 'Thương hiệu là bắt buộc.',
            // Thêm các thông báo tùy chỉnh khác nếu cần
        ];
    }
}
