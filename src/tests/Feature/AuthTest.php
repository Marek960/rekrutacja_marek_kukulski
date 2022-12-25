<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_register(){
        $data = [
            'email' => 'user3@test.com',
            'name' => 'User1',
            'password' => 'Test@123',
        ];

        $response = $this->json('POST',route('api.register'),$data);
        $response->assertStatus(200);
        $this->assertArrayHasKey('token',$response->json());
        User::where('email','user3@test.com')->delete();
    }

    public function test_login()
    {
        User::create([
            'name' => 'test',
            'email'=>'test@gmail.com',
            'password' => bcrypt('secret1234')
        ]);
        
        $response = $this->json('POST',route('api.login'),[
            'email' => 'test@gmail.com',
            'password' => 'secret1234',
        ]);

        $response->assertStatus(200);
        $this->assertArrayHasKey('token',$response->json());
        User::where('email','test@gmail.com')->delete();
    }
}
