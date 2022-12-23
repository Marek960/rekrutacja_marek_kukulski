<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;
use App\Repositories\ProductRepository;
use App\Models\Product;
use App\Models\Price;

class ProductService
{
    public function __construct(ProductRepository $productRepository, Product $product, Price $price)
    {
        $this->productRepository = $productRepository;
        $this->product = $product;
        $this->price = $price;
    }

    /**
     * @param array $data
     * @return Builder
     */
    public function index($data)
    {
        return $this->productRepository->listProducts($data);
    }

    public function show($id)
    {
        return $this->productRepository->showProduct($id);
    }

    public function store(Array $data)
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

    public function update(Request $request, $id)
    {
        $product = $this->product->with('prices')->findOrFail($id);
        $product->update([
            'name' => $request->get('name'),
            'description' => $request->get('description'),
        ]);


        foreach ($request->get('prices') as $value) {
            $price = $this->price->findOrFail($value['id']);

            $price->update([
                'price' => $value['price'],
            ]);
        }

        return response()->json('Product update successfully');
    }

    public function delete($id)
    {
        return $this->productRepository->deleteProduct($id); 
    }
}