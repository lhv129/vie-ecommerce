<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'sub_category_id' => 'required|exists:sub_categories,id',
            'brand_id' => 'required|exists:brands,id',
            'name' => 'required|string|max:100|unique:products,name',
            'slug' => 'string|max:100|unique:products,slug',
            'description' => 'required|min:200|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'sub_category_id.required' => 'Thể loại sản phẩm không được để trống.',
            'sub_category_id.exists' => 'Thể loại sản phẩm không tồn tại, vui lòng kiểm tra lại.',
            'brand_id.required' => 'Thương hiệu sản phẩm không được để trống.',
            'brand_id.exists' => 'Thương hiệu sản phẩm không tồn tại, vui lòng kiểm tra lại.',
            'name.required' => 'Tên sản phẩm không được bỏ trống.',
            'name.max' => 'Tên sản phẩm quá dài.',
            'name.unique' => 'Tên sản phẩm đã tồn tại.',
            'description.min' => 'Mô tả sản phẩm quá ngắn.',
            'description.max' => 'Mô tả sản phẩm quá dài.',
        ];
    }
}
