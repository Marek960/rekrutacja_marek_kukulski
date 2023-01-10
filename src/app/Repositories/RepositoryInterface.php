<?php

namespace App\Repositories;

interface RepositoryInterface 
{
    public function getAll($columns = array('*'));
    public function create(array $data);
    public function update(array $data, int $id);
    public function delete(int $id);
    public function find(int $id);
    public function with(string $relations);
}