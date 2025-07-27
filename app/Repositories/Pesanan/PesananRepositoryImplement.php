<?php

namespace App\Repositories\Pesanan;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Pesanan;

class PesananRepositoryImplement extends Eloquent implements PesananRepository
{

    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected Pesanan $model;

    public function __construct(Pesanan $model)
    {
        $this->model = $model;
    }
    
    public function getData()
    {
        return $this->model->with(['kategori']);
    }

    public function store($data)
    {
        return $this->model->create($data);
    }

    public function detail($id)
    {
        return $this->model->with(['kategori', 'pesananDetail'])->find($id);
    }

    public function show($id)
    {
        return $this->model->with(['kategori', 'pesananDetail'])->find($id);
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

    public function updateStatus($data)
    {
        $query = $this->model->find($data['id']);
        $query->status = $data['status'];
        $query->save();
    }
}
