<?php

namespace App\Repositories\Slider;

use LaravelEasyRepository\Repository;

interface SliderRepository extends Repository
{

    public function getData();
    public function store($data);
    public function show($id);
    public function update($data, $id);
    public function destroy($id);
}
