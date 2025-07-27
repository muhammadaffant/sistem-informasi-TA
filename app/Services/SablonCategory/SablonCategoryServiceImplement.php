<?php

namespace App\Services\SablonCategory;

use LaravelEasyRepository\ServiceApi;
use App\Repositories\SablonCategory\SablonCategoryRepository;
use Illuminate\Support\Facades\Validator;

class SablonCategoryServiceImplement extends ServiceApi implements SablonCategoryService{

    /**
     * set title message api for CRUD
     * @param string $title
     */
       protected $mainRepository;

    public function __construct(SablonCategoryRepository $mainRepository)
    {
        $this->mainRepository = $mainRepository;
    }

    public function getAll()
    {
        return $this->mainRepository->getAll();
    }

    public function create($data)
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255|unique:sablon_categories,name',
        ]);

        if ($validator->fails()) {
            return ['status' => 'error', 'errors' => $validator->errors()];
        }

        $this->mainRepository->create($data);
        return ['status' => 'success', 'message' => 'Kategori berhasil ditambahkan.'];
    }

        public function show($id)
    {
        return $this->mainRepository->show($id);
    }

    public function update($id, $data)
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255|unique:sablon_categories,name,' . $id,
        ]);

        if ($validator->fails()) {
            return ['status' => 'error', 'errors' => $validator->errors()];
        }

        $this->mainRepository->update($id, $data);
        return ['status' => 'success', 'message' => 'Kategori berhasil diperbarui.'];
    }

    public function delete($id)
    {
        // Tambahkan validasi jika kategori masih memiliki jenis sablon
        $category = $this->mainRepository->find($id);
        if ($category->jenisSablons()->count() > 0) {
            return ['status' => 'error', 'message' => 'Kategori tidak dapat dihapus karena masih memiliki detail jenis sablon.'];
        }
        
        $this->mainRepository->delete($id);
        return ['status' => 'success', 'message' => 'Kategori berhasil dihapus.'];
    }

        public function find($id)
    {
        return $this->mainRepository->find($id);
    }
}
