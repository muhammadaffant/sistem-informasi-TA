<?php

namespace App\Services\SablonCategory;

use LaravelEasyRepository\BaseService;

interface SablonCategoryService extends BaseService{

    public function getAll();
    public function create($data);
    public function show($id);
    public function update($data, $id);
    public function delete($id);
}
