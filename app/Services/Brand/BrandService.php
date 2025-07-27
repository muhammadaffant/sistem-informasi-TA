<?php

namespace App\Services\Brand;

use LaravelEasyRepository\BaseService;

interface BrandService extends BaseService
{
    public function getData();
    public function store($data);
    public function show($id);
    public function update($data, $id);
    public function destroy($id);
    public function findById($id);
}
