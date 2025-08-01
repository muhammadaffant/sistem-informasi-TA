<?php

namespace App\Services\JenisSablon;

use LaravelEasyRepository\BaseService;

interface JenisSablonService extends BaseService
{
    public function getData();
    public function store($data);
    public function show($id);
    public function update($data, $id);
    public function destroy($id);
}
