<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductAttributesRequest extends FormRequest
{
    private $table = 'product_attributes';

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'attribute_id' => 'required',
            'attribute_value_id' => 'required',
            'product_id' => 'required',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'attribute_id.required' => 'Chọn thuộc tính là bắt buộc.',
            'attribute_value_id.required' => 'Giá trị thuộc tính là bắt buộc.',
            'product_id.required' => 'ID sản phẩm là bắt buộc.',
        ];
    }
}
