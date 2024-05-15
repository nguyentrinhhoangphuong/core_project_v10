<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductsRequest extends FormRequest
{
    private $table = 'products';
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
        // bail: nghĩa là nếu vi phạm 'min:5' thì sẽ dừng lại ngay chứ k cần phải tới 'url' 'link' => 'bail|required|min:5|url',
        $id = $this->id;
        $condName = 'bail|required' . $this->table . ',name';
        if (!empty($id)) {
            $condName .= ',' . $id; // nếu có id (edit) thì ta thêm $id để không phải unique
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
            'name.unique' => 'Tên đã được sử dụng.',
        ];
    }
}
