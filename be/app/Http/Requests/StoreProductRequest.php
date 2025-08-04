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
            'images' => 'required|array|min:5|max:10', // Yêu cầu là mảng, ít nhất 5, nhiều nhất 10 phần tử
            'images.*' => 'image|mimes:jpg,jpeg,png,gif,webp|max:2048', // Mỗi phần tử trong mảng phải là ảnh, định dạng và kích thước
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
            'images.required' => 'Vui lòng tải lên ảnh cho sản phẩm.',
            'images.min' => 'Sản phẩm phải có ít nhất :min ảnh.', // :min sẽ được thay thế bằng giá trị 5
            'images.max' => 'Sản phẩm chỉ được có tối đa :max ảnh.', // :max sẽ được thay thế bằng giá trị 10
            'images.*.image' => 'File tải lên phải là một hình ảnh hợp lệ.',
            'images.*.mimes' => 'Định dạng ảnh không hợp lệ. Chỉ chấp nhận các định dạng: jpeg, png, jpg, gif, svg, web.',
            'images.*.max' => 'Kích thước của mỗi ảnh không được vượt quá 2MB.', // 2048 KB = 2MB
        ];
    }
}
