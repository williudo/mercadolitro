<?php

use App\Models\User;

use Tests\TestCase;

class ShowUsersTest extends TestCase
{
    /**
     * Test access list user without authentication.
     * Expects return a json with 401 - unauthorized response
     * @return void
     */
    public function testUnauthorized()
    {
        //Creates 10 ramdoms users
        $users = factory(User::class)->create();
        //make request
        $response = $this->json('GET', '/api/users');
        //checks if access is unauthorized
        $response->assertStatus(401);
    }

    /**
     * Test listing users first page of 5/10.
     * Expects return a json model pagination with 5 users
     * @return void
     */
    public function testListFirstPage()
    {
        //Creates 10 ramdoms users
        $users = factory(User::class, 10)->create();
        //acting as first user created
        $this->actingAs($users[0]);
        //make request
        $response = $this->json('GET', '/api/users?items_per_page=5');
        //checks if created 5 users
        $response->assertJsonFragment([
            'to' => 5
        ]);
    }

    /**
     * Test listing users by name filter, but not finding the user.
     * Expects return a json model pagination without any users thats match keyword
     * @return void
     */
    public function testNotFoundKeywordNameFilter()
    {
        //Creates a random user
        $user = factory(User::class)->create(['name' => 'Willian Rodrigues']);
        //acting as user created
        $this->actingAs($user);
        //make request
        $response = $this->json('GET', '/api/users?name=Cesar');
        //checks if found user
        $response->assertJsonFragment([
            'total' => 0,
            'data' => []
        ]);
    }

    /**
     * Test listing users by name filter.
     * Expects return a json model pagination with users thats match keyword
     * @return void
     */
    public function testKeywordNameFilter()
    {
        //Creates a random user
        $user = factory(User::class)->create(['name' => 'Willian Rodrigues']);
        //acting as user created
        $this->actingAs($user);
        //make request
        $response = $this->json('GET', '/api/users?name=Rodrigues');
        //checks if found user
        $response->assertJsonFragment([
            'total' => 1,
            'name' => 'Willian Rodrigues'
        ]);
    }

    /**
     * Test listing users by email filter, but not finding the user.
     * Expects return a json model pagination without any users thats match keyword
     * @return void
     */
    public function testNotFoundKeywordEmailFilter()
    {
        //Creates a random user
        $user = factory(User::class)->create(['email' => 'willian@email.com']);
        //acting as user created
        $this->actingAs($user);
        //make request
        $response = $this->json('GET', '/api/users?email=rodrigues@gmail.com');
        //checks if found user
        $response->assertJsonFragment([
            'total' => 0,
            'data' => []
        ]);
    }

    /**
     * Test listing users by email filter.
     * Expects return a json model pagination with users thats match keyword
     * @return void
     */
    public function testKeywordEmailFilter()
    {
        //Creates a random user
        $user = factory(User::class)->create(['email' => 'willian@email.com']);
        //acting as user created
        $this->actingAs($user);
        //make request
        $response = $this->json('GET', '/api/users?email=willian');
        //checks if found user
        $response->assertJsonFragment([
            'total' => 1,
            'email' => 'willian@email.com'
        ]);
    }
}
