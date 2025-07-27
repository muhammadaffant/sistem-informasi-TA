<?php

namespace App\Repositories\Shipping;

use LaravelEasyRepository\Repository;

interface ShippingRepository extends Repository
{
    public function getData();
    public function store($data);
    public function show($id);
    public function update($data, $id);
    public function destroy($id);
}
