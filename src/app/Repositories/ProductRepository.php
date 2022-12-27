<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Product;
use App\Services\Filters\FilterProvider;
use Illuminate\Database\Eloquent\Builder;

class ProductRepository
{
    public function __construct(
        public Product $product, 
        public FilterProvider $filterProvider
    ) {}

    public function listProducts(array $data): Builder
    {
        $query = $this->product->query();
        $query->with('prices');
        $query = $this->filterProvider->search($data, $query);
      
        return $query;
    }

    public function showProduct(int $id): Product
    {
        return $this->product->with('prices')->findOrFail($id);
    }

    public function deleteProduct(int $id): bool
    {
        return $this->product->with('prices')->findOrFail($id)->delete();
    }
}