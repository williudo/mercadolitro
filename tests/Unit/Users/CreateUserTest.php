<?php

use App\Models\User;
use Tests\TestCase;


class CreateUserTest extends TestCase
{
    /**
     * Test try create a user without authentication.
     * Expects return a json with 401 - unauthorized response
     * @return void
     */
    public function testUnauthorized()
    {
        //Creates 10 ramdoms users
        $users = factory(User::class)->create();
        //make request
        $this->json('POST', '/users/add', ['name'=> 'Willian Rodrigues', 'email' => 'willian@email.com', 'password' => '123456', 'password_confirmation' => '123456']);
        //checks if access is unauthorized
        $this->assertResponseStatus(401);
    }

    /**
     * Test try creates a user without pass name.
     * Expects return a json error validation
     * @return void
     */
    public function testTryCreateWithoutName()
    {
        //Create a ramdom user
        $user = factory(User::class)->create();
        //acting as first user created
        $this->actingAs($user);

        $this->json('POST', '/users/add', ['email' => 'willian@email.com', 'password' => '123456', 'password_confirmation' => '123456']);

        $this->seeJson([
            "name" => ["The name field is required."]
        ]);
        $this->assertResponseStatus(422);
    }

    /**
     * Test try creates a user without pass email.
     * Expects return a json error validation
     * @return void
     */
    public function testTryCreateWithoutEmail()
    {
        //Create a ramdom user
        $user = factory(User::class)->create();
        //acting as first user created
        $this->actingAs($user);

        $this->json('POST', '/users/add', ['name' => 'Willian Rodrigues', 'password' => '123456', 'password_confirmation' => '123456']);

        $this->seeJson([
            "email" => ["The email field is required."]
        ]);
        $this->assertResponseStatus(422);
    }

    /**
     * Test try creates a user without pass password.
     * Expects return a json error validation
     * @return void
     */
    public function testTryCreateWithoutPassword()
    {
        //Create a ramdom user
        $user = factory(User::class)->create();
        //acting as first user created
        $this->actingAs($user);

        $this->json('POST', '/users/add', ['email' => 'willian@email.com','name' => 'Willian Rodrigues', 'password_confirmation' => '123456']);

        $this->seeJson([
            "password" => ["The password field is required."]
        ]);
        $this->assertResponseStatus(422);
    }

    /**
     * Test try creates a user without pass password confirmation.
     * Expects return a json error validation
     * @return void
     */
    public function testTryCreateWithoutPasswordConfirmation()
    {
        //Create a ramdom user
        $user = factory(User::class)->create();
        //acting as first user created
        $this->actingAs($user);

        $this->json('POST', '/users/add', ['email' => 'willian@email.com', 'name' => 'Willian Rodrigues', 'password' => '123456']);

        $this->seeJson([
            "password" => ["The password confirmation does not match."]
        ]);
        $this->assertResponseStatus(422);
    }

    /**
     * Test try creates a user without pass password minimum characters.
     * Expects return a json error validation
     * @return void
     */
    public function testTryCreateWithoutPasswordMinimumCaracters()
    {
        //Create a ramdom user
        $user = factory(User::class)->create();
        //acting as first user created
        $this->actingAs($user);

        $this->json('POST', '/users/add', ['email' => 'willian@email.com', 'name' => 'Willian Rodrigues', 'password' => '123', 'password_confirmation' => '123']);

        $this->seeJson([
            "password" => ["The password must be at least 6 characters."]
        ]);
        $this->assertResponseStatus(422);
    }

    /**
 * Test try creates a user with password and password_confirmation not matching.
 * Expects return a json error validation
 * @return void
 */
    public function testTryCreatePasswordAndPasswordConfirmationNotMatch()
    {
        //Create a ramdom user
        $user = factory(User::class)->create();
        //acting as first user created
        $this->actingAs($user);

        $this->json('POST', '/users/add', ['email' => 'willian@email.com', 'name' => 'Willian Rodrigues', 'password' => '123456', 'password_confirmation' => '123457']);

        $this->seeJson([
            "password" => ["The password confirmation does not match."]
        ]);
        $this->assertResponseStatus(422);
    }

    /**
     * Test try creates a user with name exceeds maximum characters.
     * Expects return a json error validation
     * @return void
     */
    public function testTryCreateWithNameExceeds()
    {
        //Create a ramdom user
        $user = factory(User::class)->create();
        //acting as first user created
        $this->actingAs($user);

        $this->json('POST', '/users/add', ['email' => 'willian@email.com', 'name' => 'Willian Cesar Alves dos Santos Gonzaga Rodrigues Junior', 'password' => '123456', 'password_confirmation' => '123456']);

        $this->seeJson([
            "name" => ["The name may not be greater than 50 characters."]
        ]);
        $this->assertResponseStatus(422);
    }

    /**
     * Test try creates a user with email exceeds maximum characters.
     * Expects return a json error validation
     * @return void
     */
    public function testTryCreateWithEmailExceeds()
    {
        //Create a ramdom user
        $user = factory(User::class)->create();
        //acting as first user created
        $this->actingAs($user);

        $this->json('POST', '/users/add', ['email' => 'willian_cesar_alves_dos_santos_gonzaga_rodrigues_junior@email.com', 'name' => 'Willian Rodrigues', 'password' => '123456', 'password_confirmation' => '123456']);

        $this->seeJson([
            "email" => ["The email may not be greater than 50 characters."]
        ]);
        $this->assertResponseStatus(422);
    }

    /**
     * Test try creates a user with invalid email.
     * Expects return a json error validation
     * @return void
     */
    public function testTryCreateWithInvalidEmail()
    {
        //Create a ramdom user
        $user = factory(User::class)->create();
        //acting as first user created
        $this->actingAs($user);

        $this->json('POST', '/users/add', ['email' => 'willian_email.com', 'name' => 'Willian Rodrigues', 'password' => '123456', 'password_confirmation' => '123456']);

        $this->seeJson([
            "email" => ["The email must be a valid email address."]
        ]);
        $this->assertResponseStatus(422);
    }

    /**
     * Test try creates a user.
     * Expects return a json model of product
     * @return void
     */
    public function testCreate()
    {
        //Create a ramdom user
        $user = factory(User::class)->create();
        //acting as first user created
        $this->actingAs($user);
        $this->json('POST', '/users/add', ['name'=> 'Willian Rodrigues', 'email' => 'willian@email.com', 'password' => '123456', 'password_confirmation' => '123456']);

        $this->seeJson([
            "message" => 'User created',
            "name" => "Willian Rodrigues"
        ]);
        $this->assertResponseStatus(200);
    }
}
