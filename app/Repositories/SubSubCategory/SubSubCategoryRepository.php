<?php

namespace App\Repositories\SubSubCategory;

use LaravelEasyRepository\Repository;

interface SubSubCategoryRepository extends Repository
{
    public function getData();
    public function store($data);
    public function show($id);
    public function update($data, $id);
    public function destroy($id);
    public function findById($id);
}
