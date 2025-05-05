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

    public function get(array $conditions = [], array $relations = [])
    {
        return $this->model->where($conditions)->with($relations)->get();
    }

    public function getFirst(array $conditions = [], array $relations)
    {
        return $this->model->where($conditions)->with($relations)->first();
    }

    public function pagination(int $results, array $conditions, array $relations = [])
    {
        return $this->model->where($conditions)->with($relations)->paginate($results);
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