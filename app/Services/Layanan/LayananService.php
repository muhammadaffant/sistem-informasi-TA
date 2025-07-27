<?php

namespace App\Services\Layanan;

use LaravelEasyRepository\BaseService;

interface LayananService extends BaseService
{
    public function getData();
    public function store($data);
    public function show($id);
    public function update($data, $id);
    public function destroy($id);
}
