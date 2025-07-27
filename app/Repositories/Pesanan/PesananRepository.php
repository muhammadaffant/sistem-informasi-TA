<?php

namespace App\Repositories\Pesanan;

use LaravelEasyRepository\Repository;

interface PesananRepository extends Repository
{
    public function getData();
    public function store($data);
    public function detail($id);
    public function show($id);
    public function update($data, $id);
    public function destroy($id);
    public function updateStatus($data);
}
