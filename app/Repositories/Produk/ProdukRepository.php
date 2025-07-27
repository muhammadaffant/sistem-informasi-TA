<?php

namespace App\Repositories\Produk;

use LaravelEasyRepository\Repository;

interface ProdukRepository extends Repository
{
    public function getData();
    public function store($data);
    public function show($id);
    public function update($data, $id);
    public function destroy($id);
}
