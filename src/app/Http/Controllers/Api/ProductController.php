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

class ProductController extends Controller
{
    public function __construct(
        public ProductService $productService,
        public Product $product,
        public Price $price
    ) {}

    public function index(Request $request): JsonResponse|Collection
    {
        $products = $this->productService->index($request->all())->get();

        if (!$products->isEmpty()) {
            return $products; 
        } else {
            return response()->json('No data');
        }
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
        if ($this->productService->update($request->all(), $id)) {
            return response()->json('Product update successfully');
        } else {
            return response()->json('Product update not successfully');
        }
    }

    public function destroy(Request $request, int $id): JsonResponse
    { 
        $this->productService->delete($id);
        return response()->json('Product deleted successfully');
    }
}