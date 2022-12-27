<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Price;
use App\Services\ProductService;
use App\Http\Requests\ProductRequest;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /** @var Product */
    private $product;

    /** @var Price */
    private $price;

    /** @var ProductService */
    private $productService;
    /**
     * @return void
     */
    public function __construct(ProductService $productService)
    {
        $this->product = new Product();
        $this->price = new Price();
        $this->productService = $productService;
    }

    public function index(Request $request): Collection
    {
        $products = $this->productService->index($request->all());
        return $products->get(); 
    }

    public function show(int $id): Product
    {
        return $this->productService->show($id);
    }

    public function store(ProductRequest $request): JsonResponse
    {
        $this->productService->store($request->all());
        return response()->json('Product added successfully');
    }

    public function update(ProductRequest $request, int $id): JsonResponse
    {
        try {
            $this->productService->update($request->all(), $id);
        } catch (Throwable $e) {
            Log::debug($e);
            return response()->json('Product update not successfully');
        }
      
        return response()->json('Product update successfully');
    }

    public function destroy(Request $request, int $id): JsonResponse
    { 
        $this->productService->delete($id);
        return response()->json('Product deleted successfully');
    }
}