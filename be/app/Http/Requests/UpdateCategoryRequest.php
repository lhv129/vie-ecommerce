<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class UpdateCategoryRequest extends BaseFormRequest
{
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
    public function rules()
    {
        $id = $this->route('id'); // Lấy ID từ route /categories/{id}

        return [
            'name' => 'required|string|max:100|unique:categories,name,' . $id,
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên không được bỏ trống.',
            'name.max' => 'Tên danh mục quá dài',
            'name.unique' => 'Tên danh mục đã tồn tại.',
        ];
    }
}
