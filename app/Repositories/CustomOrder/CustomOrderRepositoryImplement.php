<?php

namespace App\Repositories\CustomOrder;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\CustomOrder;

class CustomOrderRepositoryImplement extends Eloquent implements CustomOrderRepository
{

    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected CustomOrder $model;

    public function __construct(CustomOrder $model)
    {
        $this->model = $model;
    }

    public function getData()
    {
        return $this->model->with('user')->orderby('id', 'DESC')->get();
    }

    public function store($data)
    {
        return $this->model->create($data);
    }

    public function show($id)
    {
        $query =  $this->model->find($id);
        $query['price'] = format_uang($query['price']);

        return $query;
    }

    public function update($data, $id)
    {
        $query = $this->model->find($id);
        if ($query->status == 'Pending') {
            $data['status'] = 'Progress';
        } else {
            $data['status'] = 'Pending';
        }


        $data['completion_date'] = now()->addWeeks(1);
        return $query->update($data);
    }

    public function destroy($id)
    {
        $query = $this->model->find($id);
        return $query->delete();
    }

    public function download($id)
    {
        return $this->model->find($id);
    }
}
