<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Price;
use App\Services\ProductService;

class ProductController extends Controller
{
    /** @var FilterProvider */
    private $service;

    /** @var Product */
    private $product;

    /** @var Price */
    private $price;
    /**
     * @return void
     */
    public function __construct(ProductService $productService)
    {
        $this->product = new Product();
        $this->productService = $productService;
    }

    public function index(Request $request)
    {
        $products = $this->productService->index($request->all());
        return $products->get(); 
    }

    public function show($id)
    {
        return $this->productService->show($id);
    }

    public function store(Request $request)
    {
        $this->productService->store($request->all());
        return response()->json('Product added successfully');
    }

    public function update(Request $request, $id)
    {
        $product = $this->product->with('prices')->findOrFail($id);
        $product->update([
            'name' => $request->get('name'),
            'description' => $request->get('description'),
        ]);

        if($request->get('prices')){
            foreach ($request->get('prices') as $value) {
                $price = $this->price->findOrFail($value['id']);
    
                $price->update([
                    'price' => $value['price'],
                ]);
            }
        }

        return response()->json('Product update successfully');
    }

    public function destroy(Request $request, $id)
    { 
        $this->productService->delete($id);
        return response()->json('Product deleted successfully');
    }
}