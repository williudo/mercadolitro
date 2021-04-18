<?php

namespace Tests\Unit\Products;

use App\Models\User;
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

        $response = $this->json('POST', '/api/products/add', ['description' => '10 em 1', 'quantity' => '20', 'price' => '19584.59', 'color' => 'grey']);

        //check if shows validation errors
        $response->assertJson(["message" => ["name" => ["Informe o nome."]]]);
        $response->assertStatus(422);
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

        $response = $this->json('POST', '/api/products/add', ['name'=> 'Tecpix', 'quantity' => '20', 'price' => '19584.59', 'color' => 'grey']);

        //check if shows validation errors
        $response->assertJson(["message" => ["description" => ["Informe a descrição."]]]);
        $response->assertStatus(422);
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

        $response = $this->json('POST', '/api/products/add', ['name'=> 'Tecpix', 'description' => '10 em 1', 'price' => '19584.59', 'color' => 'grey']);

        //check if shows validation errors
        $response->assertJson(["message" => ["quantity" => ["Informe a quantidade."]]]);
        $response->assertStatus(422);
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

        $response = $this->json('POST', '/api/products/add', ['name'=> 'Tecpix', 'description' => '10 em 1', 'quantity' => '20', 'color' => 'grey']);

        //check if shows validation errors
        $response->assertJson(["message" => ["price" => ["Informe o preço."]]]);
        $response->assertStatus(422);
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

        $response = $this->json('POST', '/api/products/add', ['name'=> 'Tecpix', 'description' => '10 em 1', 'quantity' => '20', 'price' => 'qwef', 'color' => 'red']);

        //check if shows validation errors
        $response->assertJson(["message" => ["price" => ["Preço com formato inválido."]]]);
        $response->assertStatus(422);
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

        $response = $this->json('POST', '/api/products/add', ['name'=> 'Tecpix', 'description' => '10 em 1', 'quantity' => '-1', 'price' => '19584.59', 'color' => 'red']);

        //check if shows validation errors
        $response->assertJson(["message" => ["quantity" => ["Números negativos não são permitidos."]]]);
        $response->assertStatus(422);
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

        $response = $this->json('POST', '/api/products/add', ['name'=> 'Tecpix Tecpix Tecpix Tecpix Tecpix', 'description' => '10 em 1', 'quantity' => '20', 'price' => '19584.59', 'color' => 'red']);

        //check if shows validation errors
        $response->assertJson(["message" => ["name" => ["Máximo 30 caracteres."]]]);
        $response->assertStatus(422);
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

        $response = $this->json('POST', '/api/products/add', ['name'=> 'Tecpix', 'description' => '10 e 1 10 e 1 10 e 1 10 e 1 10 e 1 10 e 1 10 e 1 10 e 1', 'quantity' => '20', 'price' => '19584.59', 'color' => 'red']);

        //check if shows validation errors
        $response->assertJson(["message" => ["description" => ["Máximo 50 caracteres."]]]);
        $response->assertStatus(422);
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
        $response = $this->json('POST', '/api/products/add', ['name'=> 'Tecpix', 'description' => '10 em 1', 'quantity' => '20', 'price' => '19584.59', 'color' => 'red']);

        //check if shows validation errors
        $response->assertJson(["message" => 'Produto Criado']);
        $response->assertStatus(200);
    }
}
