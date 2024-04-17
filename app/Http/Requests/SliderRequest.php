<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SliderRequest extends FormRequest
{
    private $table = 'sliders';
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
        $condThumb = 'bail|required|image';
        $condName = 'bail|required|between:1,100|unique:' . $this->table . ',name';
        if (!empty($id)) {
            $condThumb = 'bail|image';
            $condName .= ',' . $id; // nếu có id (edit) thì ta thêm $id để không phải unique
        }
        return [
            'name' => $condName,
            'description' => 'bail|required|min:5',
            'link' => 'bail|required|min:5|url',
            'status' => 'bail|in:active,inactive',
            'thumb' => $condThumb
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
            'description.required' => 'Trường mô tả là bắt buộc.',
            'description.min' => 'Trường mô tả phải chứa ít nhất 5 ký tự.',
            'link.required' => 'Trường liên kết là bắt buộc.',
            'link.min' => 'Trường liên kết phải chứa ít nhất 5 ký tự.',
            'link.url' => 'Trường liên kết phải là một URL hợp lệ.',
            'status.in' => 'Trường trạng thái phải là "kích hoạt" hoặc "chưa kích hoạt".',
            'thumb.required' => 'Trường thumb là bắt buộc.',
            'thumb.image' => 'Trường thumb phải là một hình ảnh.',
            'thumb.max' => 'Trường thumb không được vượt quá 100KB.',
        ];
    }
}
