<?php
namespace App\Services;

use Illuminate\Support\Str;
use App\Helpers\StringHelper;
use App\Repositories\ColorTypeRepository;
use App\Http\Requests\StoreColorTypeRequest;
use App\Http\Requests\UpdateColorTypeRequest;

class ColorTypeService{
    protected $repo;
    public function __construct(ColorTypeRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getAll()
    {
        return $this->repo->all();
    }

    public function create(StoreColorTypeRequest $request)
    {
        $data = $request->validated();
        // Tự động xử lý viết hoa chữ cái đầu tiên
        $data['name'] = StringHelper::mbUcFirst($data['name']);
        // Tự động thêm slug theo name
        $data['slug'] = Str::slug($data['name']);
        // Trả về thông tin danh mục đã thêm mới
        return $this->repo->create($data);
    }

    public function show($id){
        return $this->repo->findById($id);
    }

    public function update(UpdateColorTypeRequest $request, int $id)
    {
        $data = $request->validated();
        // Tự động xử lý viết hoa chữ cái đầu tiên
        $data['name'] = StringHelper::mbUcFirst($data['name']);
        // Tự động thêm slug theo name
        $data['slug'] = Str::slug($data['name']);
        // Cập nhật danh mục
        $this->repo->update($id, $data);
        // Trả về thông tin danh mục đã cập nhật
        return $this->repo->findById($id);
    }

    public function delete(int $id)
    {
        $colorType = $this->repo->findById($id);
        if (!$colorType) {
            return null;
        }
        $this->repo->delete($id);
        return $colorType;
    }

}