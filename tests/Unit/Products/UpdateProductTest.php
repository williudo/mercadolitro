<?php

namespace Tests\Unit\Products;

use App\Models\User;
use App\Models\Products;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
        $response = $this->json('PUT', '/api/products/update/'.$product->id, ['name'=> 'Tecpix', 'description' => '10 em 1', 'quantity' => '20', 'price' => '19584.59', 'color' => 'grey']);

        //checks if access is unauthorized
        $response->assertStatus(401);
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
        $response = $this->json('PUT', '/api/products/update/');

        //checks if access is unauthorized
        $response->assertStatus(404);
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
        $this->actingAs($user);

        $product = factory(Products::class)->create(['name' => 'Perfume Hinode']);
        $response = $this->json('PUT', '/api/products/update/123123', ['name'=> 'TV Samsumg']);

        //checks if access is unauthorized
        $response->assertStatus(404);
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

        $response = $this->json('PUT', '/api/products/update/'.$product->id, ['name'=> 'Tecpix', 'description' => '10 em 1', 'quantity' => '20', 'price' => 'qwef', 'color' => 'red']);

        $response->assertJsonFragment([
            "price" => ["Preço com formato inválido."]
        ]);
        $response->assertStatus(422);
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

        $response = $this->json('PUT', '/api/products/update/'.$product->id, ['name'=> 'Tecpix', 'description' => '10 em 1', 'quantity' => '-1', 'price' => '19584.59', 'color' => 'red']);

        $response->assertJsonFragment([
            "quantity" => ["Números negativos não são permitidos."]
        ]);
        $response->assertStatus(422);
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

        $response = $this->json('PUT', '/api/products/update/'.$product->id, ['name'=> 'Tecpix Tecpix Tecpix Tecpix Tecpix', 'description' => '10 em 1', 'quantity' => '20', 'price' => '19584.59', 'color' => 'red']);

        $response->assertJsonFragment([
            "name" => ["Máximo 30 caracteres."]
        ]);
        $response->assertStatus(422);
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

        $response = $this->json('PUT', '/api/products/update/'.$product->id, ['name'=> 'Tecpix', 'description' => '10 e 1 10 e 1 10 e 1 10 e 1 10 e 1 10 e 1 10 e 1 10 e 1', 'quantity' => '20', 'price' => '19584.59', 'color' => 'red']);

        $response->assertJsonFragment([
            "description" => ["Máximo 50 caracteres."]
        ]);
        $response->assertStatus(422);
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

        $response = $this->json('PUT', '/api/products/update/'.$product->id, ['name'=> 'Tecpix', 'description' => '10 em 1', 'quantity' => '20', 'price' => '19584.59', 'color' => 'red']);

        $response->assertJsonFragment([
            "message" => 'Produto atualizado',
            "name" => "Tecpix"
        ]);
        $response->assertStatus(200);
    }
}
