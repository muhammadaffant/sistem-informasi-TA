<?php

namespace App\Services\SubCategory;

use LaravelEasyRepository\BaseService;

interface SubCategoryService extends BaseService
{
    public function getData();
    public function store($data);
    public function show($id);
    public function update($data, $id);
    public function destroy($id);
    public function findById($id);
}
