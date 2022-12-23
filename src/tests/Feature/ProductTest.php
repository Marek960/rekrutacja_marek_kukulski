<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Product;

class ProductTest extends TestCase
{
    //Test the single show route
    public function test_show(){

        $product = Product::create([
            'name' => 'Lampa',
            'description' => 'ogrodowa'
        ]);

        $response = $this->json('GET',route('products.show',['id' => $product->id]));
        $response->assertStatus(200);
        //Assert name is correct
        $this->assertEquals('Lampa',$response->json()['name']);
    }
}
