<?php

namespace Tests\Unit\Products;

use App\Models\User;
use App\Models\Products;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowProductsTest extends TestCase
{
    /**
     * Test access list of products without authentication.
     * Expects return a json with 401 - unauthorized response
     * @return void
     */
    public function testUnauthorized()
    {
        //Creates ramdoms products
        $products = factory(Products::class)->create();
        //make request
        $response = $this->json('GET', '/api/products');

        //checks if access is unauthorized
        $response->assertStatus(401);
    }

    /**
     * Test listing products first page of 5/10.
     * Expects return a json model pagination with 5 products
     * @return void
     */
    public function testListFirstPage()
    {
        //Create a ramdom user
        $user = factory(User::class)->create();
        //Creates ramdoms products
        $products = factory(Products::class, 10)->create();
        //acting as first user created
        $this->actingAs($user);
        //make request
        $response = $this->json('GET', '/api/products?items_per_page=5');
        //checks if created 5 products
        $response->assertJsonFragment(['to' => 5]);
        $response->assertStatus(200);
    }

    /**
     * Test listing products by name filter, but not finding the product.
     * Expects return a json model pagination without any products
     * @return void
     */
    public function testNotFoundKeywordNameFilter()
    {
        //Creates a random user
        $user = factory(User::class)->create();
        //Creates ramdom product
        $product = factory(Products::class)->create(['name' => 'Perfume Hinode']);
        //acting as user created
        $this->actingAs($user);
        //make request
        $response = $this->json('GET', '/api/products?name=Tecpix');

        //checks if not found product
        $response->assertJsonFragment(['to' => null]);
        $response->assertStatus(200);
    }

    /**
     * Test listing products by name filter.
     * Expects return a json model pagination with products thats match keyword
     * @return void
     */
    public function testKeywordNameFilter()
    {
        //Creates a random user
        $user = factory(User::class)->create();
        //Creates ramdom product
        $product = factory(Products::class)->create(['name' => 'Perfume Hinode']);
        //acting as user created
        $this->actingAs($user);
        //make request
        $response = $this->json('GET', '/api/products?name=hinode');
        //checks if found product
        $response->assertJsonFragment([
            'total' => 1,
            'name' => 'Perfume Hinode'
        ]);
        $response->assertStatus(200);
    }

    /**
     * Test listing products by description filter, but not finding the product.
     * Expects return a json model pagination without any products
     * @return void
     */
    public function testNotFoundKeywordDescriptionFilter()
    {
        //Creates a random user
        $user = factory(User::class)->create();
        //Creates ramdom product
        $product = factory(Products::class)->create(['name' => 'Tecpix', 'description' => 'A melhor câmera do mercado, ela é 10 em 1']);
        //acting as user created
        $this->actingAs($user);
        //make request
        $response = $this->json('GET', '/api/products?description=perfume');

        //checks if not found product
        $response->assertJsonFragment(['to' => null]);
        $response->assertStatus(200);
    }

    /**
     * Test listing products by description filter.
     * Expects return a json model pagination with products thats match keyword
     * @return void
     */
    public function testKeywordDescriptionFilter()
    {
        //Creates a random user
        $user = factory(User::class)->create();
        //Creates ramdom product
        $product = factory(Products::class)->create(['name' => 'Tecpix', 'description' => 'A melhor câmera do mercado, ela é 10 em 1']);
        //acting as user created
        $this->actingAs($user);
        //make request
        $response = $this->json('GET', '/api/products?description=10 em 1');

        //checks if found product
        $response->assertJsonFragment([
            'total' => 1,
            'name' => 'Tecpix',
            'description' => 'A melhor câmera do mercado, ela é 10 em 1'
        ]);
        $response->assertStatus(200);
    }

    /**
     * Test listing products by color filter, but not finding the product.
     * Expects return a json model pagination withot any products
     * @return void
     */
    public function testNotFoundKeywordColorFilter()
    {
        //Creates a random user
        $user = factory(User::class)->create();
        //Creates ramdom product
        $product = factory(Products::class)->create(['name' => 'Tecpix', 'color' => 'grey']);
        //acting as user created
        $this->actingAs($user);
        //make request
        $response = $this->json('GET', '/api/products?color=Red');

        //checks if not found product
        $response->assertJsonFragment([
            'total' => 0,
            'data' => []
        ]);

        $response->assertStatus(200);
    }

    /**
     * Test listing products by color filter.
     * Expects return a json model pagination with products thats match keyword
     * @return void
     */
    public function testKeywordColorFilter()
    {
        //Creates a random user
        $user = factory(User::class)->create();
        //Creates ramdom product
        $product = factory(Products::class)->create(['name' => 'Tecpix', 'color' => 'grey']);
        //acting as user created
        $this->actingAs($user);
        //make request
        $response = $this->json('GET', '/api/products?color=Grey');

        //checks if found product
        $response->assertJsonFragment([
            'total' => 1,
            'name' => 'Tecpix',
            'color' => 'grey'
        ]);

        $response->assertStatus(200);
    }
}
