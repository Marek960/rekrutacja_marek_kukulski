<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Product;
use App\Models\User;

class ProductTest extends TestCase
{
    use RefreshDatabase;
    public function test_list(){
        Product::create([
            'name' => 'Lampa',
            'description' => 'lampa ogrodowa'
        ]);

        $response = $this->json('get',route('api.products.index'));
        $response->assertStatus(200);


        $this->assertEquals(1,count($response->json()));
        $this->assertEquals('Lampa',$response->json()[0]['name']);
    }

    public function test_show(){
        $product = Product::create([
            'name' => 'Lampa',
            'description' => 'lampa ogrodowa'
        ]);

        $response = $this->json('get',route('api.products.show',['id' => $product->id]));
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

        $response = $this->json('post',route('api.login'),[
            'email' => 'test80@gmail.com',
            'password' => 'secret1234',
        ]);

        $response->assertStatus(200);
        $this->assertArrayHasKey('token',$response->json());
        $token = $response['token'];
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('post',route('api.products.create'),[
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

        $response = $this->json('post',route('api.login'),[
            'email' => 'test80@gmail.com',
            'password' => 'secret1234',
        ]);

        $response->assertStatus(200);
        $this->assertArrayHasKey('token',$response->json());
        $token = $response['token'];

        $product = Product::create([
            'name' => 'Kubek',
            'description' => 'Kubek swiateczny',
            'prices' => [
                ['price' => 777]
            ]
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('put',route('api.products.update',['id' => $product['id']]),[
            'name' => 'Kubek',
            'description' => 'Kubek swiateczny',
            'prices' => [
                [
                    'id' => 1,
                    'price' => 771
                ]
            ]
        ]);
        $response->assertStatus(200);
    }

    public function test_delete(){
        $this->withoutExceptionHandling();
        User::create([
            'name' => 'test',
            'email'=>'test88@gmail.com',
            'password' => bcrypt('secret1234')
        ]);

        $response = $this->json('post',route('api.login'),[
            'email' => 'test88@gmail.com',
            'password' => 'secret1234',
        ]);

        $response->assertStatus(200);
        $this->assertArrayHasKey('token',$response->json());
        $token = $response['token'];

        $product = Product::create([
            'name' => 'Stol',
            'description' => 'Stol ogrodowy'
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('delete',route('api.products.delete',['id' => $product['id']]));
        $response->assertStatus(200);
    }
}
