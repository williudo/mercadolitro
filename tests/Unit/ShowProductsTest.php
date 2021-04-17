<?php

use App\Models\User;
use App\Models\Products;
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
        $this->json('GET', '/products');
        //checks if access is unauthorized
        $this->assertResponseStatus(401);
    }
    /**
     * Test list products, but not having a database records.
     * Expects return a json model pagination without any product
     * @return void
     */
    public function testListNone()
    {
        //Create a ramdom user
        $user = factory(User::class)->create();
        //acting as first user created
        $this->actingAs($user);
        //make request
        $this->json('GET', '/products');
        //checks if not have products
        $this->seeJson([
            'total' => 0,
            'data' => []
        ]);
    }

    /**
     * Test listing 10 products.
     * Expects return a json model pagination with 10 products
     * @return void
     */
    public function testList10()
    {
        //Create a ramdom user
        $user = factory(User::class)->create();
        //Creates ramdoms products
        $products = factory(Products::class, 10)->create();
        //acting as first user created
        $this->actingAs($user);
        //make request
        $this->json('GET', '/products');
        //checks if created 10 products
        $this->seeJson([
            'total' => 10
        ]);
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
        $this->json('GET', '/products?items_per_page=5');
        //checks if created 5 products
        $this->seeJson([
            'to' => 5,
            'total' => 10
        ]);
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
        $this->json('GET', '/products?name=Tecpix');
        //checks if not found product
        $this->seeJson([
            'total' => 0,
            'data' => []
        ]);
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
        $this->json('GET', '/products?name=hinode');
        //checks if found product
        $this->seeJson([
            'total' => 1,
            'name' => 'Perfume Hinode'
        ]);
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
        $this->json('GET', '/products?description=perfume');
        //checks if found product
        $this->seeJson([
            'total' => 0,
            'data' => []
        ]);
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
        $this->json('GET', '/products?description=10 em 1');
        //checks if found product
        $this->seeJson([
            'total' => 1,
            'name' => 'Tecpix',
            'description' => 'A melhor câmera do mercado, ela é 10 em 1'
        ]);
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
        $this->json('GET', '/products?color=Red');
        //checks if found product
        $this->seeJson([
            'total' => 0,
            'data' => []
        ]);
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
        $this->json('GET', '/products?color=Grey');
        //checks if found product
        $this->seeJson([
            'total' => 1,
            'name' => 'Tecpix',
            'color' => 'grey'
        ]);
    }
}
