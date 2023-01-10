<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use App\Repositories\PriceRepository;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;

class ProductService
{
    public function __construct(
        public ProductRepository $productRepository, 
        public PriceRepository $priceRepository
    ) {}

    public function index(Array $data): Builder
    {
        return $this->productRepository->listProducts($data);
    }

    public function show(int $id): Product|null
    {
        return $this->productRepository->with('prices')->find($id);
    }

    public function store(Array $data): void
    {
        $product = $this->productRepository->create(
            ['name' => $data['name'], 'description' => $data['description']]
        );
        $productId = $product->id;

        foreach ($data['prices'] as $price) {
            $product = $this->priceRepository->create(
                ['product_id' => $productId, 'price' => $price['price']]
            );
        } 
    }

    public function update(array $data, int $id): bool
    {
        $product = $this->productRepository->with('prices')->find($id);
        if ($product) {
            $this->productRepository->update(
                ['name' => $data['name'], 'description' => $data['description']], $id
            );
            foreach ($data['prices'] as $value) {
                if ($this->priceRepository->find($value['id'])) {
                    $price = $this->priceRepository->find($value['id']);
                    if ($price) {
                        $this->priceRepository->update(
                            [ 'price' => $value['price']], $value['id']
                        );
                    }
                } else {
                    return false;
                }
            }
            return true;
        } else {
            return false;
        }
    }

    public function delete(int $id): bool
    {
        return $this->productRepository->delete($id); 
    }
}