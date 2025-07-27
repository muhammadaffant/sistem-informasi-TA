<?php

namespace App\Services\Slider;

use LaravelEasyRepository\BaseService;

interface SliderService extends BaseService
{
    public function getData();
    public function store($data);
    public function show($id);
    public function update($data, $id);
    public function destroy($id);
}
