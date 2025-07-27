<?php

namespace App\Repositories\Category;

use App\Models\Category;
use Illuminate\Support\Str;
use LaravelEasyRepository\Implementations\Eloquent;

class CategoryRepositoryImplement extends Eloquent implements CategoryRepository
{

    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected Category $model;

    public function __construct(Category $model)
    {
        $this->model = $model;
    }

    public function getData()
    {
        return $this->model->all();
    }

    public function store($data)
    {
        $data['category_slug'] = Str::slug($data['category_name']);
        return $this->model->create($data);
    }

    public function show($id)
    {
        return $this->model->find($id);
    }

    public function update($data, $id)
    {
        $query = $this->model->find($id);

        if (isset($data['category_name'])) {
            $data['category_slug'] = Str::slug($data['category_name']);
        }

        return $query->update($data);
    }

    public function destroy($id)
    {
        $query = $this->model->find($id);
        return $query->delete();
    }

    public function findByName($data)
    {
        return $this->model->where('category_name', 'like', '%' . $data . '%')->get();
    }
}
