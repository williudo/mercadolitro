<?php

use App\Models\User;
use App\Models\Products;
    use Tests\TestCase;

class UpdateProductTest extends TestCase
{
    /**
     * Test update a product without authentication.
     * Expects return a json with 401 - unauthorized response
     * @return void
     */
    public function testUnauthorized()
    {
        //Updates 1 ramdoms users
        $users = factory(User::class)->create();
        //Creates ramdom product
        $product = factory(Products::class)->create(['name' => 'Perfume Hinode']);
        //make request
        $this->json('POST', '/products/update/'.$product->id, ['name'=> 'Tecpix', 'description' => '10 em 1', 'quantity' => '20', 'price' => '19584.59', 'color' => 'grey']);
        //checks if access is unauthorized
        $this->assertResponseStatus(401);
    }

    /**
     * Test try update a product without product id.
     * Expects return a json with 401 - unauthorized response
     * @return void
     */
    public function testUpdateWithoutProductID()
    {
        //Creates 1 ramdoms user
        $user = factory(User::class)->create();
        //Acting as user
        $this->actingAs($user);
        //Creates ramdom product
        $product = factory(Products::class)->create(['name' => 'Perfume Hinode']);
        //make request
        $this->json('POST', '/users/update/', ['name'=> 'Willian Rodrigues', 'email' => 'willian@email.com', 'password' => '123456', 'password_confirmation' => '123456']);
        //checks if access is unauthorized
        $this->assertResponseStatus(404);
    }

    /**
     * Test try update a product with invalid product id.
     * Expects return a json with 401 - unauthorized response
     * @return void
     */
    public function testUpdateWithInvalidProductID()
    {
        //Creates 1 ramdoms user
        $user = factory(User::class)->create();
        //Acting as user
        $this->actingAs($user);
        //Creates ramdom product
        $product = factory(Products::class)->create(['name' => 'Perfume Hinode']);
        //make request
        $this->json('POST', '/users/update/wad666668', ['name'=> 'Willian Rodrigues', 'email' => 'willian@email.com', 'password' => '123456', 'password_confirmation' => '123456']);
        //checks if access is unauthorized
        $this->assertResponseStatus(404);
    }

    /**
     * Test try creates a product without pass name.
     * Expects return a json error validation
     * @return void
     */
    public function testTryUpdateWithoutName()
    {
        //Update a ramdom user
        $user = factory(User::class)->create();
        //acting as first user created
        $this->actingAs($user);
        //Creates ramdom product
        $product = factory(Products::class)->create(['name' => 'Perfume Hinode']);

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
    public function testTryUpdateWithoutDescription()
    {
        //Update a ramdom user
        $user = factory(User::class)->create();
        //acting as first user created
        $this->actingAs($user);
        //Creates ramdom product
        $product = factory(Products::class)->create(['name' => 'Perfume Hinode']);

        $this->json('POST', '/products/update/'.$product->id, ['name'=> 'Tecpix', 'quantity' => '20', 'price' => '19584.59', 'color' => 'grey']);

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
    public function testTryUpdateWithoutQuantity()
    {
        //Update a ramdom user
        $user = factory(User::class)->create();
        //acting as first user created
        $this->actingAs($user);
        //Creates ramdom product
        $product = factory(Products::class)->create(['name' => 'Perfume Hinode']);

        $this->json('POST', '/products/update/'.$product->id, ['name'=> 'Tecpix', 'description' => '10 em 1', 'price' => '19584.59', 'color' => 'grey']);

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
    public function testTryUpdateWithoutPrice()
    {
        //Update a ramdom user
        $user = factory(User::class)->create();
        //acting as first user created
        $this->actingAs($user);
        //Creates ramdom product
        $product = factory(Products::class)->create(['name' => 'Perfume Hinode']);

        $this->json('POST', '/products/update/'.$product->id, ['name'=> 'Tecpix', 'description' => '10 em 1', 'quantity' => '20', 'color' => 'grey']);

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
    public function testTryUpdateWithWrongColor()
    {
        //Update a ramdom user
        $user = factory(User::class)->create();
        //acting as first user created
        $this->actingAs($user);
        //Creates ramdom product
        $product = factory(Products::class)->create(['name' => 'Perfume Hinode']);

        $this->json('POST', '/products/update/'.$product->id, ['name'=> 'Tecpix', 'description' => '10 em 1', 'quantity' => '20', 'price' => '19584.59', 'color' => '25']);

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
    public function testTryUpdateWithWrongPrice()
    {
        //Update a ramdom user
        $user = factory(User::class)->create();
        //acting as first user created
        $this->actingAs($user);
        //Creates ramdom product
        $product = factory(Products::class)->create(['name' => 'Perfume Hinode']);

        $this->json('POST', '/products/update/'.$product->id, ['name'=> 'Tecpix', 'description' => '10 em 1', 'quantity' => '20', 'price' => 'qwef', 'color' => 'red']);

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
    public function testTryUpdateWithWrongQuantity()
    {
        //Update a ramdom user
        $user = factory(User::class)->create();
        //acting as first user created
        $this->actingAs($user);
        //Creates ramdom product
        $product = factory(Products::class)->create(['name' => 'Perfume Hinode']);

        $this->json('POST', '/products/update/'.$product->id, ['name'=> 'Tecpix', 'description' => '10 em 1', 'quantity' => '-1', 'price' => '19584.59', 'color' => 'red']);

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
    public function testTryUpdateWithNameExceeds()
    {
        //Update a ramdom user
        $user = factory(User::class)->create();
        //acting as first user created
        $this->actingAs($user);
        //Creates ramdom product
        $product = factory(Products::class)->create(['name' => 'Perfume Hinode']);

        $this->json('POST', '/products/update/'.$product->id, ['name'=> 'Tecpix Tecpix Tecpix Tecpix Tecpix', 'description' => '10 em 1', 'quantity' => '20', 'price' => '19584.59', 'color' => 'red']);

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
    public function testTryUpdateWithDescriptionExceeds()
    {
        //Update a ramdom user
        $user = factory(User::class)->create();
        //acting as first user created
        $this->actingAs($user);
        //Creates ramdom product
        $product = factory(Products::class)->create(['name' => 'Perfume Hinode']);

        $this->json('POST', '/products/update/'.$product->id, ['name'=> 'Tecpix', 'description' => '10 e 1 10 e 1 10 e 1 10 e 1 10 e 1 10 e 1 10 e 1 10 e 1', 'quantity' => '20', 'price' => '19584.59', 'color' => 'red']);

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
    public function testUpdate()
    {
        //Update a ramdom user
        $user = factory(User::class)->create();
        //acting as first user created
        $this->actingAs($user);
        //Creates ramdom product
        $product = factory(Products::class)->create(['name' => 'Perfume Hinode']);

        $this->json('POST', '/products/update/'.$product->id, ['name'=> 'Tecpix', 'description' => '10 em 1', 'quantity' => '20', 'price' => '19584.59', 'color' => 'red']);

        $this->seeJson([
            "message" => 'Product updated',
            "name" => "Tecpix"
        ]);
        $this->assertResponseStatus(200);
    }
}
