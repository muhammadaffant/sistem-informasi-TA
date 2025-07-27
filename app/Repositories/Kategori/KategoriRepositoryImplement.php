<?php

namespace App\Repositories\Kategori;

use App\Models\Kategori;
use Illuminate\Support\Str;
use LaravelEasyRepository\Implementations\Eloquent;

class KategoriRepositoryImplement extends Eloquent implements KategoriRepository
{

    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected Kategori $model;

    public function __construct(Kategori $model)
    {
        $this->model = $model;
    }

    public function getData()
    {
        return $this->model->all();
    }

    public function store($data)
    {
        $data['slug'] = Str::slug($data['nama_kategori']);
        return $this->model->create($data);
    }

    public function show($id)
    {
        return $this->model->find($id);
    }

    public function update($data, $id)
    {
        $query = $this->model->find($id);

        if (isset($data['nama_kategori'])) {
            $data['slug'] = Str::slug($data['nama_kategori']);
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
        return $this->model->where('nama_kategori', 'like', '%' . $data . '%')->get();
    }
}
