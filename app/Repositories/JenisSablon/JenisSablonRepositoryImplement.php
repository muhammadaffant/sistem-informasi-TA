<?php

namespace App\Repositories\JenisSablon;

use App\Models\JenisSablon;
use Illuminate\Support\Str;
use LaravelEasyRepository\Implementations\Eloquent;

class JenisSablonRepositoryImplement extends Eloquent implements JenisSablonRepository
{

    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected JenisSablon $model;

    public function __construct(JenisSablon $model)
    {
        $this->model = $model;
    }

    public function getData()
    {
        // MODIFIKASI: Tambahkan with('sablonCategory') untuk eager loading
        return $this->model->with('sablonCategory')->oldest()->get();
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
