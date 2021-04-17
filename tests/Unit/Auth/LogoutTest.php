<?php

use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    /**
     * Test try logout a user without authentication.
     * Expects return a json with 401 - unauthorized response
     * @return void
     */
    public function testUnauthorized()
    {
        //Creates 1 ramdoms user
        $users = factory(User::class)->create();
        //make request
        $this->json('GET', '/logout');
        //checks if access is unauthorized
        $this->assertResponseStatus(401);
    }
}
