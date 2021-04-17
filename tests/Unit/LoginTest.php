<?php

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
        //Acting as user
        $this->actingAs($user);
        //make request
        $this->json('POST', '/login', ['email'=> 'willian@email.com']);
        //check if shows validation errors
        $this->seeJson([
            "password" => ["The password field is required."]
        ]);
        $this->assertResponseStatus(422);
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
        //Acting as user
        $this->actingAs($user);
        //make request
        $this->json('POST', '/login', ['password'=> '123456']);
        //check if shows validation errors
        $this->seeJson([
            "email" => ["The email field is required."]
        ]);
        $this->assertResponseStatus(422);
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
        //Acting as user
        $this->actingAs($user);
        //make request
        $this->json('POST', '/login', ['email'=> 'willian@email.com', 'password' => '123456']);
        //check if shows validation errors
        $this->seeJson([
            "error" => "Invalid user credentials"
        ]);
        $this->assertResponseStatus(401);
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
        $this->json('POST', '/login', ['email'=> 'willian@email.com', 'password' => '1qaz2wsx']);
        //check if shows jwt token
        $this->seeJson([
            "token_type" => "bearer",
        ]);
        $this->seeJsonStructure(['access_token']);
        $this->assertResponseStatus(200);
    }
}
