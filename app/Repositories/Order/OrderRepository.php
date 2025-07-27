<?php

namespace App\Repositories\Order;

use LaravelEasyRepository\Repository;

interface OrderRepository extends Repository
{
    public function getData();
    public function getByOwner($filters);
    public function store($data);
    public function show($id);
    public function update($data, $id);
    public function destroy($id);
    public function download($id);
}
