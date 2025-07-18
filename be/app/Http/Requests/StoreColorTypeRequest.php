<?php

namespace App\Http\Requests;
use App\Http\Requests\BaseFormRequest;

class StoreColorTypeRequest extends BaseFormRequest
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
        return [
            'name' => 'required|string|max:100|unique:color_types,name',
            'slug' => 'string|max:100|unique:color_types,slug',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên màu sắc sản phẩm không được bỏ trống.',
            'name.unique' => 'Tên màu sắc sản phẩm đã tồn tại.',
            'slug.unique' => 'Slug đã được sử dụng, vui lòng đổi tên hoặc slug.',
        ];
    }
}
