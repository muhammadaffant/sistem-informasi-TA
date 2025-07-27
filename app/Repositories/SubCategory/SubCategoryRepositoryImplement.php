<?php

namespace App\Repositories\SubCategory;

use App\Models\SubCategory;
use Illuminate\Support\Str;
use LaravelEasyRepository\Implementations\Eloquent;

class SubCategoryRepositoryImplement extends Eloquent implements SubCategoryRepository
{

    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected SubCategory $model;

    public function __construct(SubCategory $model)
    {
        $this->model = $model;
    }
    public function getData()
    {
        return $this->model->with(['category'])->latest()->get();
    }

    public function store($data)
    {
        $data['subcategory_slug'] = Str::slug($data['subcategory_name']);
        return $this->model->create($data);
    }

    public function show($id)
    {
        return $this->model->with(['category'])->find($id);
    }

    public function update($data, $id)
    {
        $query = $this->model->find($id);

        if (isset($data['subcategory_name'])) {
            $data['subcategory_slug'] = Str::slug($data['subcategory_name']);
        }

        return $query->update($data);
    }

    public function destroy($id)
    {
        $query = $this->model->find($id);
        return $query->delete();
    }

    public function findById($id)
    {
        return $this->model->where('category_id', 'like', '%' . $id . '%')->get();
    }
}
