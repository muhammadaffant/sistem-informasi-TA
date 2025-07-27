<?php

namespace App\Repositories\Pembelian;

use LaravelEasyRepository\Repository;

interface PembelianRepository extends Repository
{
    public function getData();
    public function store($data);
    public function detail($id);
    public function show($id);
    public function update($data, $id);
    public function destroy($id);
}
