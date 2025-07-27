<?php

namespace App\Repositories\Product;

use LaravelEasyRepository\Repository;

interface ProductRepository extends Repository
{
    public function getData();
    public function store($data);
    public function detail($id);
    public function show($id);
    public function update($data, $id);
    public function destroy($id);
}
