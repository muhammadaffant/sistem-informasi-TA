<?php

namespace App\Repositories\Kategori;

use LaravelEasyRepository\Repository;

interface KategoriRepository extends Repository
{
    public function getData();
    public function store($data);
    public function show($id);
    public function update($data, $id);
    public function destroy($id);
    public function findByName($data);
}
