<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use App\Services\Filters\FilterProvider;

class ProductRepository
{
    public function __construct(Product $product, FilterProvider $filterProvider)
    {
        $this->product = $product;
        $this->filterProvider = $filterProvider;
    }

    public function listProducts($data)
    {
        $query = $this->product->query();
        $query->with('prices');
        $query = $this->filterProvider->search($data, $query);
      
        return $query;
    }

    public function showProduct($id)
    {
        return $this->product->with('prices')->find($id);
    }

    public function deleteProduct($id)
    {
        return $this->product->with('prices')->find($id)->delete();
    }
}