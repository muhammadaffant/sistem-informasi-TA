<?php

namespace App\Repositories\SubSubCategory;

use Illuminate\Support\Str;
use App\Models\SubSubCategory;
use LaravelEasyRepository\Implementations\Eloquent;

class SubSubCategoryRepositoryImplement extends Eloquent implements SubSubCategoryRepository
{

    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected SubSubCategory $model;

    public function __construct(SubSubCategory $model)
    {
        $this->model = $model;
    }

    public function getData()
    {
        return $this->model->with(['category', 'subCategory'])->latest()->get();
    }

    public function store($data)
    {
        $data['subsubcategory_slug'] = Str::slug($data['subsubcategory_name']);
        return $this->model->create($data);
    }

    public function show($id)
    {
        return $this->model->with(['category', 'subCategory'])->find($id);
    }

    public function update($data, $id)
    {
        $query = $this->model->find($id);

        if (isset($data['subsubcategory_name'])) {
            $data['subsubcategory_slug'] = Str::slug($data['subsubcategory_name']);
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
        return $this->model->where('sub_category_id', 'like', '%' . $id . '%')->get();
    }
}
