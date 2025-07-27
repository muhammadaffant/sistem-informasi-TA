<?php

namespace App\Services\SubSubCategory;

use LaravelEasyRepository\BaseService;

interface SubSubCategoryService extends BaseService
{
    public function getData();
    public function store($data);
    public function show($id);
    public function update($data, $id);
    public function destroy($id);
    public function findById($id);
}
