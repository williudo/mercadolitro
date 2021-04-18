<?php

use Tests\TestCase;
use App\Models\User;

class DeleteUserTest extends TestCase
{
    /**
     * Test try delete a user without authentication.
     * Expects return a json with 401 - unauthorized response
     * @return void
     */
    public function testUnauthorized()
    {
        //Creates 1 ramdoms user
        $users = factory(User::class)->create();
        //make request
        $response = $this->json('DELETE', '/api/users/delete/'.$users->id);
        //checks if access is unauthorized
        $response->assertStatus(401);
    }

    /**
     * Test try delete a user without user id.
     * Expects return a json with 404 - Not Found
     * @return void
     */
    public function testDeleteWithoutUserID()
    {
        //Creates 1 ramdoms user
        $user = factory(User::class)->create();
        //Acting as user
        $this->actingAs($user);
        //make request
        $response = $this->json('DELETE', '/api/users/delete/');
        //checks if access is not found
        $response->assertStatus(404);
    }

    /**
     * Test try delete a user with invalid user id.
     * Expects return a json with 404 - Not Found
     * @return void
     */
    public function testDeleteWithInvalidUserID()
    {
        //Creates 1 ramdoms user
        $user = factory(User::class)->create();
        //Acting as user
        $this->actingAs($user);
        //make request
        $response = $this->json('DELETE', '/api/users/delete/4848446');
        //checks if access is not found
        $response->assertStatus(404);
    }

    /**
     * Test try delete a user.
     * Expects return a json message
     * @return void
     */
    public function testDelete()
    {
        //Creates 1 ramdoms user
        $user = factory(User::class)->create();
        //Acting as user
        $this->actingAs($user);
        //make request
        $response = $this->json('DELETE', '/api/users/delete/'.$user->id);
        //checks if deleted
        $response->assertStatus(200);
        $response->assertJsonFragment(['message' => 'Usuário Deletado.']);
    }
}
