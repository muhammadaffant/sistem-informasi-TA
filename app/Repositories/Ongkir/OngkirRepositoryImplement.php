<?php

namespace App\Repositories\Ongkir;

use App\Models\Ongkir;
use App\Models\Province;
use Illuminate\Support\Str;
use LaravelEasyRepository\Implementations\Eloquent;

class OngkirRepositoryImplement extends Eloquent implements OngkirRepository
{

    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected Ongkir $model;

    public function __construct(Ongkir $model)
    {
        $this->model = $model;
    }

    public function getData()
    {
        return $this->model->all();
    }

    public function store($data)
    {
        $data['ongkir'] = str_replace('.', '', $data['ongkir']);
        return $this->model->create($data);
    }

    public function show($id)
    {
        return $this->model->with(['province', 'regency', 'district', 'village'])->find($id);
    }

    public function update($data, $id)
    {
        $query = $this->model->find($id);
        $data['ongkir'] = str_replace('.', '', $data['ongkir']);

        return $query->update($data);
    }

    public function destroy($id)
    {
        $query = $this->model->find($id);
        return $query->delete();
    }

    public function getProvince()
    {
        $query = Province::get();
        return $query;
    }
}
