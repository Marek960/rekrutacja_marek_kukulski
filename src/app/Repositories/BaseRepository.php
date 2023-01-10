<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Repositories\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class BaseRepository implements RepositoryInterface
{
    protected $model;
    public function getAll($columns = array('*')): Collection 
    {
        return $this->model->get($columns);
    }

    public function create(array $data): Model 
    {
        return $this->model->create($data);
    }

    public function update(array $data, int $id): Int
    {
        return $this->model->where('id', $id)->update($data);
    }

    public function delete(int $id): int
    {
        return $this->model->destroy($id);
    }

    public function find(int $id): Model|null
    {
        return $this->model->find($id);
    }

    public function with(string $relations): Builder
    {
        return $this->model->with($relations);
    }
}