<?php

namespace App\Services\Ongkir;

use LaravelEasyRepository\BaseService;

interface OngkirService extends BaseService
{
    public function getData();
    public function getProvince();
    public function store($data);
    public function show($id);
    public function update($data, $id);
    public function destroy($id);
}
