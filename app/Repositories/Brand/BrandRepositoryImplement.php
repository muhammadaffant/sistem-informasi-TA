<?php

namespace App\Repositories\Brand;

use App\Models\Brand;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use LaravelEasyRepository\Implementations\Eloquent;

class BrandRepositoryImplement extends Eloquent implements BrandRepository
{

    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected Brand $model;

    public function __construct(Brand $model)
    {
        $this->model = $model;
    }
    public function getData()
    {
        return $this->model->all();
    }

    public function store($data)
    {
        // $$data['brand_name'];
        // $data['brand_image'] = $this->handleUploadedFile($data['brand_image'] ?? null, 'brand');

        return $this->model->create($data);
    }

    public function show($id)
    {
        return $this->model->find($id);
    }

    public function update($data, $id)
    {
        $query = $this->model->find($id);

        if (isset($data['brand_name']))

        // if (isset($data['brand_image'])) {
        //     $this->deleteFileIfExists($query->brand_image);
        //     $data['brand_image'] = $this->handleUploadedFile($data['brand_image'], 'brand');
        // }

        return $query->update($data);
    }

    public function destroy($id)
    {
        $query = $this->model->find($id);

        $this->deleteFileIfExists($query->brand_image);
        return $query->delete();
    }

    public function findById($id)
    {
        return $this->model->where('id', 'like', '%' . $id . '%')->get();
    }

    /**
     * Handle file upload and return the file path.
     */
    private function handleUploadedFile($file, $folder)
    {
        if ($file instanceof \Illuminate\Http\UploadedFile) {
            return upload($folder, $file, $folder);
        }
        return null;
    }

    /**
     * Delete a file if it exists.
     */
    private function deleteFileIfExists($filePath)
    {
        if ($filePath && Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }
    }
}
