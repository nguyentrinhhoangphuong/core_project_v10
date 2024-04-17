<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
{
    private $table = 'articles';
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
        $condName = 'bail|required|between:1,100|unique:' . $this->table . ',title';
        $condThumb = 'bail|required|image|max:500';
        if (!empty($id)) {
            $condName .= ',' . $id; // nếu có id (edit) thì ta thêm $id để không phải unique
            $condThumb = 'bail|image|max:500';
        }
        return [
            'title' => $condName,
            'status' => 'bail|in:active,inactive',
            'content' => 'bail|required',
            'thumb' => $condThumb,
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
            'title.required' => 'Trường title là bắt buộc.',
            'title.between' => 'Trường title phải chứa ít nhất từ :min đến :max ký tự.',
            'title.unique' => 'Title đã được sử dụng.',
            'status.in' => 'Trường trạng thái phải phải là "kích hoạt" hoặc "chưa kích hoạt".',
            'content.required' => 'Trường content là bắt buộc.',
            'thumb.required' => 'Trường thumb là bắt buộc.',
        ];
    }
}
