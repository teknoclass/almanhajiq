<?php

namespace App\Repositories;

class MainRepository
{
    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function findById($id)
    {
        return $this->model->find($id);
    }
    public function findByIdWith($id, ?array $with = null, ?array $count = null)
    {
        $query = $this->model->newQuery();

        if (!empty($with)) {
            $query->with($with);
        }

        if (!empty($count)) {
            $query->withCount($count);
        }

        return $query->find($id);
    }
}
