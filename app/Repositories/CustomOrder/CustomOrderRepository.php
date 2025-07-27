<?php

namespace App\Repositories\CustomOrder;

use LaravelEasyRepository\Repository;

interface CustomOrderRepository extends Repository
{
    public function getData();
    public function store($data);
    public function show($id);
    public function update($data, $id);
    public function destroy($id);
    public function download($id);
}
