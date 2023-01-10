<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Product;
use App\Services\Filters\FilterProvider;
use Illuminate\Database\Eloquent\Builder;

class ProductRepository extends BaseRepository
{
    public function __construct(
        Product $model, 
        public FilterProvider $filterProvider
    ) {
        $this->model = $model;
    }

    public function listProducts(array $data): Builder
    {
        $query = $this->model->query();
        $query->with('prices');
        $query = $this->filterProvider->search($data, $query);
      
        return $query;
    }
}