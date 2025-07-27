<?php

namespace App\Services\Shipping;

use LaravelEasyRepository\BaseService;

interface ShippingService extends BaseService
{
    public function getData();
    public function store($data);
    public function show($id);
    public function update($data, $id);
    public function destroy($id);
}
