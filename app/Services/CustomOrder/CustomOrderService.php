<?php

namespace App\Services\CustomOrder;

use LaravelEasyRepository\BaseService;

interface CustomOrderService extends BaseService
{
    public function getData();
    public function store($data);
    public function show($id);
    public function update($data, $id);
    public function destroy($id);
    public function download($id);
}
