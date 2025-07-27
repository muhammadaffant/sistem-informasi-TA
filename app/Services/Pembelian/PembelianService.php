<?php

namespace App\Services\Pembelian;

use LaravelEasyRepository\BaseService;

interface PembelianService extends BaseService
{
    public function getData();
    public function store($data);
    public function detail($id);
    public function show($id);
    public function update($data, $id);
    public function destroy($id);
}
