<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Product;
use App\Services\Filters\FilterProvider;
use Illuminate\Database\Eloquent\Builder;

class ProductRepository
{
    private $product;
    private $filterProvider;

    public function __construct(Product $product, FilterProvider $filterProvider)
    {
        $this->product = $product;
        $this->filterProvider = $filterProvider;
    }

    public function listProducts(array $data): Builder
    {
        $query = $this->product->query();
        $query->with('prices');
        $query = $this->filterProvider->search($data, $query);
      
        return $query;
    }

    public function showProduct(int $id): Product
    {
        return $this->product->with('prices')->find($id);
    }

    public function deleteProduct(int $id)
    {
        return $this->product->with('prices')->findOrFail($id)->delete();
    }
}