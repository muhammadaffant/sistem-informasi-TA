<?php

namespace App\Services\Product;

use LaravelEasyRepository\BaseService;

interface ProductService extends BaseService
{
    public function getData();
    public function store($data);
    public function detail($id);
    public function show($id);
    public function update($data, $id);
    public function destroy($id);
}
