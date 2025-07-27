<?php

namespace App\Repositories\SablonCategory;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\SablonCategory;

class SablonCategoryRepositoryImplement extends Eloquent implements SablonCategoryRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(SablonCategory $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->oldest()->get();
    }

    // Write something awesome :)
}
