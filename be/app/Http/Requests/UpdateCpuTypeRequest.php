<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class UpdateCpuTypeRequest extends BaseFormRequest
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
    public function rules(): array
    {
        $id = $this->route('id');
        return [
            'name' => 'required|string|max:100|unique:cpu_types,name,' . $id,
            'slug' => 'string|max:100|unique:cpu_types,slug',
            'family' => 'required|string|max:30|min:5',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên màu sắc sản phẩm không được bỏ trống.',
            'name.unique' => 'Tên màu sắc sản phẩm đã tồn tại.',
            'slug.unique' => 'Slug đã được sử dụng, vui lòng đổi tên hoặc slug.',
            'family.required' => 'Vui lòng nhập dòng CPU',
            'family.max' => 'Dòng CPU quá dài hãy ghi ngắn gọn',
            'family.min' => 'Dòng CPU quá ngắn, vui lòng kiểm tra lại',
        ];
    }
}
