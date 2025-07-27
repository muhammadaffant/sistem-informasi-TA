<?php

namespace App\Repositories\SubCategory;

use LaravelEasyRepository\Repository;

interface SubCategoryRepository extends Repository
{
    public function getData();
    public function store($data);
    public function show($id);
    public function update($data, $id);
    public function destroy($id);
    public function findById($data);
}
