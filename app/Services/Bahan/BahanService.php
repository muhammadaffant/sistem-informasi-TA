<?php

namespace App\Services\Bahan;

use LaravelEasyRepository\BaseService;

interface BahanService extends BaseService
{
    public function getData();
    public function store($data);
    public function show($id);
    public function update($data, $id);
    public function destroy($id);
}
