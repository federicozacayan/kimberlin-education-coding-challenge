<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;


class ExampleTest extends TestCase
{
    public function testRegister()
    {
        DB::beginTransaction();
        $response = $this->json('POST', '/api/register', [
            'name' => 'tdd',
            'email' => 'tdd@mail.com',
            'password' => 'secret',
            'c_password' => 'secret',
        ]);
        DB::rollback();
        $response->assertStatus(201);
    }


    public function testLoginFail()
    {
        DB::beginTransaction();
        $response = $this->json('POST', '/api/register', [
            'name' => 'tdd',
            'email' => 'tdd@mail.com',
            'password' => 'secret',
            'c_password' => 'secret',
        ]);

        $response2 = $this->json('POST', '/api/login', [
            'email' => 'tdd@mail.com',
            'password' => 'wrongPassword'
        ]);
        DB::rollback();
        $response2->assertStatus(401);
    }

    public function testLogin()
    {
        DB::beginTransaction();
        $response = $this->json('POST', '/api/register', [
            'name' => 'tdd',
            'email' => 'tdd@mail.com',
            'password' => 'secret',
            'c_password' => 'secret',
        ]);

        $response2 = $this->json('POST', '/api/login', [
            'email' => 'tdd@mail.com',
            'password' => 'secret'
        ]);
        DB::rollback();
        $response2->assertStatus(200);
    }
}
