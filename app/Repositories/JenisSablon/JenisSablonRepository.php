<?php

namespace App\Repositories\JenisSablon;

use LaravelEasyRepository\Repository;

interface JenisSablonRepository extends Repository
{
    public function getData();
    public function store($data);
    public function show($id);
    public function update($data, $id);
    public function destroy($id);
}
