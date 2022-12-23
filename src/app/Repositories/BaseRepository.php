<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class BaseRepository
{
    private $model;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function list()
    {
        return $this->model->with('prices');
    }
}