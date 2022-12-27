<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use App\Models\Product;
use App\Models\Price;
use Illuminate\Database\Eloquent\Builder;

class ProductService
{
    public function __construct(
        public ProductRepository $productRepository, 
        public Product $product, 
        public Price $price
    ) {}

    public function index(Array $data): Builder
    {
        return $this->productRepository->listProducts($data);
    }

    public function show(int $id): Product
    {
        return $this->productRepository->showProduct($id);
    }

    public function store(Array $data): void
    {
        $product = $this->product->create([
            'name' => $data['name'],
            'description' => $data['description'],
        ]);
        $productId = $product->id;

        foreach ($data['prices'] as $price) {
            $this->price->create([
                'product_id' => $productId,
                'price' => $price['price'],
            ]);
        } 
    }

    public function update(array $data, int $id): bool
    {
        $product = $this->product->with('prices')->find($id);
        if ($product) {
            $product->update([
                'name' => $data['name'],
                'description' => $data['description'],
            ]);

            foreach ($data['prices'] as $value) {
                $price = $this->price->find($value['id']);
                if ($price) {
                    $price->update([
                        'price' => $value['price'],
                    ]);
                }
            }
            return true;
        } else {
            return false;
        }
    }

    public function delete(int $id): bool
    {
        return $this->productRepository->deleteProduct($id); 
    }
}