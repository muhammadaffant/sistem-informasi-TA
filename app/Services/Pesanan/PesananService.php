<?php

namespace App\Services\Pesanan;

use LaravelEasyRepository\BaseService;

interface PesananService extends BaseService
{
    public function getData();
    public function store($data);
    public function detail($id);
    public function show($id);
    public function update($data, $id);
    public function destroy($id);
    public function updateStatus($data);
}
