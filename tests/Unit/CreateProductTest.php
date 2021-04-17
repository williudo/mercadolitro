<?php

use App\Models\User;
use App\Models\Products;
use Tests\TestCase;

class CreateProductTest extends TestCase
{
    /**
     * Test create a product without authentication.
     * Expects return a json with 401 - unauthorized response
     * @return void
     */
    public function testUnauthorized()
    {
        //make request
        $response = $this->json('POST', '/api/products/add', ['name'=> 'Tecpix', 'description' => '10 em 1', 'quantity' => '20', 'price' => '19584.59', 'color' => 'grey']);
        //checks if access is unauthorized

        $response->assertStatus(401);
    }

    /**
     * Test try creates a product without pass name.
     * Expects return a json error validation
     * @return void
     */
    public function testTryCreateWithoutName()
    {
        //Create a ramdom user
        $user = factory(User::class)->create();
        //acting as first user created
        $this->actingAs($user);

        $this->json('POST', '/users/add', ['description' => '10 em 1', 'quantity' => '20', 'price' => '19584.59', 'color' => 'grey']);

        $this->seeJson([
            "name" => ["The name field is required."]
        ]);
        $this->assertResponseStatus(422);
    }
    /**
     * Test try creates a product without pass description.
     * Expects return a json error validation
     * @return void
     */
    public function testTryCreateWithoutDescription()
    {
        //Create a ramdom user
        $user = factory(User::class)->create();
        //acting as first user created
        $this->actingAs($user);

        $this->json('POST', '/products/add', ['name'=> 'Tecpix', 'quantity' => '20', 'price' => '19584.59', 'color' => 'grey']);

        $this->seeJson([
            "description" => ["The description field is required."]
        ]);
        $this->assertResponseStatus(422);
    }
    /**
     * Test try creates a product without pass quantity.
     * Expects return a json error validation
     * @return void
     */
    public function testTryCreateWithoutQuantity()
    {
        //Create a ramdom user
        $user = factory(User::class)->create();
        //acting as first user created
        $this->actingAs($user);

        $this->json('POST', '/products/add', ['name'=> 'Tecpix', 'description' => '10 em 1', 'price' => '19584.59', 'color' => 'grey']);

        $this->seeJson([
            "quantity" => ["The quantity field is required."]
        ]);
        $this->assertResponseStatus(422);
    }
    /**
     * Test try creates a product without pass price.
     * Expects return a json error validation
     * @return void
     */
    public function testTryCreateWithoutPrice()
    {
        //Create a ramdom user
        $user = factory(User::class)->create();
        //acting as first user created
        $this->actingAs($user);

        $this->json('POST', '/products/add', ['name'=> 'Tecpix', 'description' => '10 em 1', 'quantity' => '20', 'color' => 'grey']);

        $this->seeJson([
            "price" => ["The price field is required."]
        ]);
        $this->assertResponseStatus(422);
    }
    /**
     * Test try creates a product with wrong color.
     * Expects return a json error validation
     * @return void
     */
    public function testTryCreateWithWrongColor()
    {
        //Create a ramdom user
        $user = factory(User::class)->create();
        //acting as first user created
        $this->actingAs($user);

        $this->json('POST', '/products/add', ['name'=> 'Tecpix', 'description' => '10 em 1', 'quantity' => '20', 'price' => '19584.59', 'color' => '25']);

        $this->seeJson([
            "color" => ["The selected color is invalid."]
        ]);
        $this->assertResponseStatus(422);
    }

    /**
     * Test try creates a product with wrong price.
     * Expects return a json error validation
     * @return void
     */
    public function testTryCreateWithWrongPrice()
    {
        //Create a ramdom user
        $user = factory(User::class)->create();
        //acting as first user created
        $this->actingAs($user);

        $this->json('POST', '/products/add', ['name'=> 'Tecpix', 'description' => '10 em 1', 'quantity' => '20', 'price' => 'qwef', 'color' => 'red']);

        $this->seeJson([
            "price" => ["The price must be a number."]
        ]);
        $this->assertResponseStatus(422);
    }

    /**
     * Test try creates a product with wrong quantity.
     * Expects return a json error validation
     * @return void
     */
    public function testTryCreateWithWrongQuantity()
    {
        //Create a ramdom user
        $user = factory(User::class)->create();
        //acting as first user created
        $this->actingAs($user);

        $this->json('POST', '/products/add', ['name'=> 'Tecpix', 'description' => '10 em 1', 'quantity' => '-1', 'price' => '19584.59', 'color' => 'red']);

        $this->seeJson([
            "quantity" => ["The quantity must be at least 0."]
        ]);
        $this->assertResponseStatus(422);
    }

    /**
     * Test try creates a product thats exceeds characters in name field.
     * Expects return a json error validation
     * @return void
     */
    public function testTryCreateWithNameExceeds()
    {
        //Create a ramdom user
        $user = factory(User::class)->create();
        //acting as first user created
        $this->actingAs($user);

        $this->json('POST', '/products/add', ['name'=> 'Tecpix Tecpix Tecpix Tecpix Tecpix', 'description' => '10 em 1', 'quantity' => '20', 'price' => '19584.59', 'color' => 'red']);

        $this->seeJson([
            "name" => ["The name may not be greater than 30 characters."]
        ]);
        $this->assertResponseStatus(422);
    }

    /**
    * Test try creates a product thats exceeds characters in description field.
    * Expects return a json error validation
    * @return void
    */
    public function testTryCreateWithDescriptionExceeds()
    {
        //Create a ramdom user
        $user = factory(User::class)->create();
        //acting as first user created
        $this->actingAs($user);

        $this->json('POST', '/products/add', ['name'=> 'Tecpix', 'description' => '10 e 1 10 e 1 10 e 1 10 e 1 10 e 1 10 e 1 10 e 1 10 e 1', 'quantity' => '20', 'price' => '19584.59', 'color' => 'red']);

        $this->seeJson([
            "description" => ["The description may not be greater than 50 characters."]
        ]);
        $this->assertResponseStatus(422);
    }

    /**
     * Test try creates a product.
     * Expects return a json model of product
     * @return void
     */
    public function testCreate()
    {
        //Create a ramdom user
        $user = factory(User::class)->create();
        //acting as first user created
        $this->actingAs($user);
        $this->json('POST', '/products/add', ['name'=> 'Tecpix', 'description' => '10 em 1', 'quantity' => '20', 'price' => '19584.59', 'color' => 'red']);

        $this->seeJson([
            "message" => 'Product created',
            "name" => "Tecpix"
        ]);
        $this->assertResponseStatus(200);
    }
}
