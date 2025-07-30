<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'sub_category_id' => 'required|exists:sub_categories,id',
            'brand_id' => 'required|exists:brands,id',
            'name' => 'required|string|max:100|unique:products,name,' . $id,
            'slug' => 'string|max:100|unique:products,slug',
            'description' => 'required|min:200|max:2048',
            'features' => 'required|min:200|max:1000',
            'images.*' => 'image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'sub_category_id.required' => 'Danh mục sản phẩm không được để trống.',
            'sub_category_id.exists' => 'Danh mục sản phẩm không tồn tại, vui lòng kiểm tra lại.',
            'brand_id.required' => 'Thương hiệu sản phẩm không được để trống.',
            'brand_id.exists' => 'Thương hiệu sản phẩm không tồn tại, vui lòng kiểm tra lại.',
            'name.required' => 'Tên sản phẩm không được bỏ trống.',
            'name.max' => 'Tên sản phẩm quá dài.',
            'name.unique' => 'Tên sản phẩm đã tồn tại.',
            'description.required' => 'Vui lòng nhập mô tả sản phẩm.',
            'description.min' => 'Mô tả sản phẩm quá ngắn.',
            'description.max' => 'Mô tả sản phẩm quá dài.',
            'features.required' => 'Vui lòng nhập mô tả sản phẩm nổi bật.',
            'features.min' => 'Mô tả sản phẩm nổi bật quá ngắn.',
            'features.max' => 'Mô tả sản phẩm nổi bật quá dài.',
            'images.*.image' => 'File tải lên phải là một hình ảnh hợp lệ.',
            'images.*.mimes' => 'Định dạng ảnh không hợp lệ. Chỉ chấp nhận các định dạng: jpeg, png, jpg, gif, svg, web.',
            'images.*.max' => 'Kích thước của mỗi ảnh không được vượt quá 2MB.', // 2048 KB = 2MB
        ];
    }
}
