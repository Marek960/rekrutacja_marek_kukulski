<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Price;
use App\Services\Filters\FilterProvider;

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
    public function __construct(FilterProvider $filterProvider)
    {
        $this->product = new Product();
        $this->price = new Price();
        $this->filterProvider = $filterProvider;
    }

    public function index(Request $request)
    {
        $query = $this->product->query();
        $query->with('prices');
        $query = $this->filterProvider->search($request->all(), $query);

        return $query->get(); 
    }

    public function show($id)
    {
        return $this->product->with('prices')->find($id);
    }

    public function store(Request $request)
    {
        $product = $this->product->create([
            'name' => $request->get('name'),
            'description' => $request->get('description'),
        ]);
        $productId = $product->id;

        foreach ($request->get('prices') as $price) {
            $this->price->create([
                'product_id' => $productId,
                'price' => $price['price'],
            ]);
        }

        return response()->json('Product added successfully');
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

    public function destroy(Request $request, $id)
    { 
        $product = $this->product->find($id);
        if ($product) {
            $product->delete();
            return response()->json('Product deleted successfully');
        }
        return response()->json('Data not found', 404); 
    }
}