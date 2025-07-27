<?php

namespace App\Repositories\Slider;

use App\Models\Slider;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use LaravelEasyRepository\Implementations\Eloquent;

class SliderRepositoryImplement extends Eloquent implements SliderRepository
{

    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected Slider $model;

    public function __construct(Slider $model)
    {
        $this->model = $model;
    }

    public function getData()
    {
        return $this->model->all();
    }

    public function store($data)
    {
        $data['slider_slug'] = Str::slug($data['title']);
        $data['slider_img'] = $this->handleUploadedFile($data['slider_img'] ?? null, 'sliders');

        return $this->model->create($data);
    }

    public function show($id)
    {
        return $this->model->find($id);
    }

    public function update($data, $id)
    {
        $query = $this->model->find($id);

        if (isset($data['title'])) {
            $data['slider_slug'] = Str::slug($data['title']);
        }

        if (isset($data['slider_img'])) {
            $this->deleteFileIfExists($query->slider_img);
            $data['slider_img'] = $this->handleUploadedFile($data['slider_img'], 'brand');
        }

        return $query->update($data);
    }

    public function destroy($id)
    {
        $query = $this->model->find($id);

        $this->deleteFileIfExists($query->slider_img);
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
        if ($file instanceof UploadedFile) {
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
