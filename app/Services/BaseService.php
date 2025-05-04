<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;

class BaseService
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        return $this->model->all();
    }

    public function get(array $conditions = [])
    {
        return $this->model->where($conditions)->get();
    }

    public function getFirst(array $conditions = [])
    {
        return $this->model->where($conditions)->first();
    }

    public function pagination(int $results)
    {
        return $this->model->paginate($results);
    }

    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    public function store(array $data)
    {
        return $this->model->create($data);
    }

    public function update(Model $model, array $data)
    {
        $model->update($data);
        return $model;
    }

    public function destroy(Model $model)
    {
        $model->delete();
        return $model;
    }

    public function search(string $query)
    {
        return $this->model->search($query)->get();
    }

}