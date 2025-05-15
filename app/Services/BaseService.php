<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

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

    public function pagination(int $results = 10, array $conditions = [], array $relations = [])
    {
        return $this->model->where($conditions)->with($relations)->paginate($results);
    }

    public function find($id, array $conditions = [], array $relations = [])
    {
        return $this->model->where($conditions)->with($relations)->findOrFail($id);
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

    public function scoutSearch(string $field, array $conditions = [], array $relations = [], int $perPage = 0)
    {
        $collection = $this->model->search($field)->get();

        if (!empty($conditions)) {
            $collection = $collection->filter(function ($item) use ($conditions) {
                foreach ($conditions as $key => $value) {
                    if ($item->$key != $value) {
                        return false;
                    }
                }
                return true;
            });
        }

        if (!empty($relations)) {
            $collection->load($relations);
        }

        if ($perPage > 0) {
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $items = $collection->forPage($currentPage, $perPage)->values();
            return new LengthAwarePaginator(
                $items,
                $collection->count(),
                $perPage,
                $currentPage,
                ['path' => request()->url(), 'query' => request()->query()]
            );
        }

        return $collection->values();
    }
}
