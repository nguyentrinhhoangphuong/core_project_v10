<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryProductsRequest extends FormRequest
{
    private $table = 'category_products';

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
        $id = $this->id;
        $condName = 'bail|required';
        if (!empty($id)) {
            $condName .= ',' . $id;
        }
        return [
            'name' => $condName,
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
            'name.required' => 'Trường tên là bắt buộc.',
            'name.between' => 'Trường tên phải chứa ít nhất từ :min đến :max ký tự.',
        ];
    }
}
