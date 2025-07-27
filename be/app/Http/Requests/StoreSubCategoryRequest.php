<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSubCategoryRequest extends FormRequest
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
        return [
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:100|unique:sub_categories,name',
            'slug' => 'nullable|string|max:100|unique:sub_categories,slug',
            'image' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'fileImage' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'category_id.required' => 'Danh mục không được để trống.',
            'category_id.exists' => 'Danh mục không tồn tại, vui lòng kiểm tra lại.',
            'name.required' => 'Tên danh mục sản phẩm không được bỏ trống.',
            'name.max' => 'Tên danh mục sản phẩm quá dài.',
            'name.unique' => 'Tên danh mục sản phẩm đã tồn tại.',
            'image.image' => 'File upload phải là ảnh hợp lệ.',
            'image.required' => 'Vui lòng nhập ảnh cho danh mục sản phẩm.',
            'image.mimes' => 'Chỉ nhận ảnh jpg,jpeg,png,gif,webp',
            'image.max' => 'Kích thước ảnh tối đa 2MB.',
        ];
    }
}
