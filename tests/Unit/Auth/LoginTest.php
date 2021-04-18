<?php

namespace Tests\Unit\Auth;

use App\Models\User;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * Test try login a user without password.
     * Expects return a json with 422 - invalid data
     * @return void
     */
    public function testLoginWithoutPassword()
    {
        //Creates 1 ramdoms user
        $user = factory(User::class)->create(['email'=> 'willian@email.com']);
        $this->actingAs($user);

        //make request
        $response = $this->json('POST', '/api/login', ['email'=> 'willian@email.com']);

        //check if shows validation errors
        $response->assertJson(["message" => ["password" => ["Informe a senha."]]]);
    }

    /**
     * Test try login a user without email.
     * Expects return a json with 422 - invalid data
     * @return void
     */
    public function testLoginWithoutEmail()
    {
        //Creates 1 ramdoms user
        $user = factory(User::class)->create(['email'=> 'willian@email.com']);
        $this->actingAs($user);

        //make request
        $response = $this->json('POST', '/api/login', ['password'=> '123456']);

        //check if shows validation errors
        $response->assertJson(["message" => ["email" => ["Informe o email."]]]);
        $response->assertStatus(422);
    }

    /**
     * Test try login a user with invalid credentials.
     * Expects return a json with 401 - unauthorized response
     * @return void
     */
    public function testLoginWithInvalidCredentials()
    {
        //Creates 1 ramdoms user
        $user = factory(User::class)->create(['email'=> 'willian@email.com']);
        $this->actingAs($user);

        //make request
        $response = $this->json('POST', '/api/login', ['email'=> 'willian@email.com', 'password'=> '123456']);

        //check if shows validation errors
        $response->assertJson(["error" => "Credenciais inválidas."]);
        $response->assertStatus(401);
    }

    /**
     * Test try login a user.
     * Expects return a json with jwt token
     * @return void
     */
    public function testLogin()
    {
        //Creates 1 ramdoms user
        $user = factory(User::class)->create(['email'=> 'willian@email.com']);
        //Acting as user
        $this->actingAs($user);
        //make request
        $response = $this->json('POST', '/api/login', ['email'=> 'willian@email.com', 'password' => '1qaz2wsx']);
        //check if shows jwt token
        $response->assertJson([
            "token_type" => "bearer"
        ]);
        $response->assertJsonStructure(['access_token']);
        $response->assertStatus(200);
    }
}
