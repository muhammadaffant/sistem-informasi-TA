<?php

namespace App\Repositories\Ongkir;

use LaravelEasyRepository\Repository;

interface OngkirRepository extends Repository
{
    public function getData();
    public function getProvince();
    public function store($data);
    public function show($id);
    public function update($data, $id);
    public function destroy($id);
}
