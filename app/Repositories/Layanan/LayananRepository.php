<?php

namespace App\Repositories\Layanan;

use LaravelEasyRepository\Repository;

interface LayananRepository extends Repository
{
    /**
     * Get all Layanan data.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getData();
    public function store($data);
    public function show($id);
    public function update($data, $id);
    public function destroy($id);
}
