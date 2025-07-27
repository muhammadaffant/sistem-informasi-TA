<?php

namespace App\Services\Order;

use LaravelEasyRepository\BaseService;

interface OrderService extends BaseService
{
    public function getData();
    public function getByOwner($filters);
    public function store($data);
    public function show($id);
    public function update($data, $id);
    public function destroy($id);
    public function download($id);
}
