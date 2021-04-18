<?php

namespace Tests\Unit\Auth;

use App\Models\User;
use Tests\TestCase;

class RefreshTest extends TestCase
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

        $response = $this->json('PUT', '/api/refresh');

        //checks if access is unauthorized
        $response->assertStatus(401);
    }
    /**
     * Test try creates a product without pass description.
     * Expects return a json error validation
     * @return void
     */
    public function testRefreshToken()
    {
        //Creates 1 ramdoms user
        $users = factory(User::class)->create(['email'=> 'willian@email.com']);
        $this->actingAs($users);
        $response = $this->json('POST', '/api/login', ['email'=> 'willian@email.com', 'password' => '1qaz2wsx']);
        $content_response = json_decode($response->getContent());

        $response = $this->json('PUT', '/api/refresh', [], ['Authorization => Bearer'.$content_response->access_token]);

        //checks if access is unauthorized
        $response->assertStatus(200);
    }
}
