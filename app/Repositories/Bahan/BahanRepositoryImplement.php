<?php

namespace App\Repositories\Bahan;

use App\Models\Bahan;
use Illuminate\Support\Str;
use LaravelEasyRepository\Implementations\Eloquent;

class BahanRepositoryImplement extends Eloquent implements BahanRepository
{

    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected Bahan $model;

    public function __construct(Bahan $model)
    {
        $this->model = $model;
    }

    public function getData()
    {
        return $this->model->all();
    }

    public function store($data)
    {
        return $this->model->create($data);
    }

    public function show($id)
    {
        return $this->model->find($id);
    }

    public function update($data, $id)
    {
        $query = $this->model->find($id);
        return $query->update($data);
    }

    public function destroy($id)
    {
        $query = $this->model->find($id);
        return $query->delete();
    }
}
