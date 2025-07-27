<?php

namespace App\Repositories\Bahan;

use LaravelEasyRepository\Repository;

interface BahanRepository extends Repository
{
    public function getData();
    public function store($data);
    public function show($id);
    public function update($data, $id);
    public function destroy($id);
}
