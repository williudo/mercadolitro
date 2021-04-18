<?php

namespace Tests\Unit\Auth;

use App\Models\User;
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
        $response = $this->json('GET', '/api/logout');

        //checks if access is unauthorized
        $response->assertStatus(401);
    }
}
