<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBrandRequest extends FormRequest
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
            'name' => 'required|string|max:15|unique:brands,name',
            'slug' => 'nullable|string|max:15|unique:brands,slug',
            'image' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'fileImage' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên thương hiệu không được bỏ trống.',
            'name.max' => 'Tên thương hiệu quá dài.',
            'name.unique' => 'Tên thương hiệu đã tồn tại.',
            'image.image' => 'File upload phải là ảnh hợp lệ.',
            'image.required' => 'Vui lòng nhập ảnh cho thương hiệu.',
            'image.mimes' => 'Chỉ nhận ảnh jpg,jpeg,png,gif,webp',
            'image.max' => 'Kích thước ảnh tối đa 2MB.',
        ];
    }
}
