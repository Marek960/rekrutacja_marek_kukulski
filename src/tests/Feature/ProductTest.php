<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Product;
use App\Models\User;

class ProductTest extends TestCase
{
    // use RefreshDatabase;

    public function test_list(){
        $product = Product::create([
            'name' => 'Lampa',
            'description' => 'lampa ogrodowa'
        ]);

        $response = $this->json('GET',route('api.products.index'));
        $response->assertStatus(200);


        $this->assertEquals(1,count($response->json()));
        $this->assertEquals('Lampa',$response->json()[0]['name']);
    }

    public function test_show(){
        $product = Product::create([
            'name' => 'Lampa',
            'description' => 'lampa ogrodowa'
        ]);

        $response = $this->json('GET',route('api.products.show',['id' => $product->id]));
        $response->assertStatus(200);

        $this->assertEquals('Lampa',$response->json()['name']);
    }
  
    public function test_create()
    {
        User::create([
            'name' => 'test',
            'email'=>'test80@gmail.com',
            'password' => bcrypt('secret1234')
        ]);

        $response = $this->json('POST',route('api.login'),[
            'email' => 'test80@gmail.com',
            'password' => 'secret1234',
        ]);

        $response->assertStatus(200);
        $this->assertArrayHasKey('token',$response->json());
        $token = $response['token'];
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('POST',route('api.products.create'),[
            'name' => 'Kubek',
            'description' => 'Kubek swiateczny',
            'prices' => [
                ['price' => 777]
            ]
        ]);
        $response->assertStatus(200);

        User::where('email','test80@gmail.com')->delete();
    }

    public function test_update(){
        $this->withoutExceptionHandling();
        User::create([
            'name' => 'test',
            'email'=>'test80@gmail.com',
            'password' => bcrypt('secret1234')
        ]);

        $response = $this->json('POST',route('api.login'),[
            'email' => 'test80@gmail.com',
            'password' => 'secret1234',
        ]);

        $response->assertStatus(200);
        $this->assertArrayHasKey('token',$response->json());
        $token = $response['token'];

        $product = Product::create([
            'name' => 'Koszulka',
            'description' => 'Koszulka swiateczna',
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('PUT',route('api.products.update',['id' => $product['id']]),[
            'name' => 'Kubek1',
            'description' => 'Kubek swiateczny1',
        ]);
        $response->assertStatus(200);
    }

    //Test the delete route
    // public function testDelete(){
    //     $token = $this->authenticate();
    //     $recipe = Product::create([
    //         'title' => 'Jollof Rice',
    //         'procedure' => 'Parboil rice, get pepper and mix, and some spice and serve!'
    //     ]);
    //     $this->user->recipes()->save($recipe);
    //     $response = $this->withHeaders([
    //         'Authorization' => 'Bearer '. $token,
    //     ])->json('POST',route('recipe.delete',['recipe' => $recipe->id]));
    //     $response->assertStatus(200);
    //     //Assert there are no recipes
    //     $this->assertEquals(0,$this->user->recipes()->count());
    // }
}
