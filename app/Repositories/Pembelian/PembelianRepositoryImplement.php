<?php

namespace App\Repositories\Pembelian;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Pembelian;

class PembelianRepositoryImplement extends Eloquent implements PembelianRepository
{

    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected Pembelian $model;

    public function __construct(Pembelian $model)
    {
        $this->model = $model;
    }

    public function getData()
    {
        return $this->model->with(['user']);
    }

    public function store($data)
    {
        return $this->model->create($data);
    }

    public function detail($id)
    {
        return $this->model->with(['kategori', 'user', 'pembelianDetail.produk'])->find($id);
    }

    public function show($id)
    {
        return $this->model->with(['kategori', 'user', 'pembelianDetail.produk'])->find($id);
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
