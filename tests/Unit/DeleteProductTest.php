<?php

use App\Models\User;
use App\Models\Products;
use Tests\TestCase;


class DeleteProductTest extends TestCase
{
    /**
     * Test try delete a product without authentication.
     * Expects return a json with 401 - unauthorized response
     * @return void
     */
    public function testUnauthorized()
    {
        //Creates 1 ramdoms user
        $users = factory(User::class)->create();
        //Creates ramdom product
        $product = factory(Products::class)->create(['name' => 'Perfume Hinode']);
        //make request
        $this->json('GET', '/products/delete/'.$users->id);
        //checks if access is unauthorized
        $this->assertResponseStatus(401);
    }

    /**
     * Test try delete a product without product id.
     * Expects return a json with 404 - Not Found
     * @return void
     */
    public function testDeleteWithoutProductID()
    {
        //Creates 1 ramdoms user
        $user = factory(User::class)->create();
        //Acting as user
        $this->actingAs($user);
        //Creates ramdom product
        $product = factory(Products::class)->create(['name' => 'Perfume Hinode']);
        //make request
        $this->json('GET', '/products/delete/');
        //checks if access is not found
        $this->assertResponseStatus(404);
    }

    /**
     * Test try delete a product with invalid product id.
     * Expects return a json with 404 - Not Found
     * @return void
     */
    public function testDeleteWithInvalidProductID()
    {
        //Creates 1 ramdoms user
        $user = factory(User::class)->create();
        //Acting as user
        $this->actingAs($user);
        //Creates ramdom product
        $product = factory(Products::class)->create(['name' => 'Perfume Hinode']);
        //make request
        $this->json('GET', '/products/delete/4848446');
        //checks if access is not found
        $this->assertResponseStatus(404);
    }

    /**
     * Test try delete a product.
     * Expects return a json message
     * @return void
     */
    public function testDelete()
    {
        //Creates 1 ramdoms user
        $user = factory(User::class)->create();
        //Acting as user
        $this->actingAs($user);
        //Creates ramdom product
        $product = factory(Products::class)->create(['name' => 'Perfume Hinode']);
        //make request
        $this->json('GET', '/products/delete/'.$product->id);
        //checks if deleted
        $this->assertResponseStatus(200);
        $this->seeJson(['message' => 'Product deleted']);
    }
}
