<?php
namespace Tests\Unit\Products;

use App\Models\User;
use App\Models\Products;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteProductTest extends TestCase
{

    /**
     * Test try delete a product without authentication.
     * Expects return a json with 401 - unauthorized response
     * @return void
     */
    public function testUnauthorized()
    {
        //Creates ramdom product
        $product = factory(Products::class)->create(['name' => 'Perfume Hinode']);

        //make request
        $response = $this->json('DELETE', '/api/products/delete/'.$product->id);

        //checks if access is unauthorized
        $response->assertStatus(401);
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
        $response = $this->json('DELETE', '/api/products/delete/');

        //checks if access is unauthorized
        $response->assertStatus(404);
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
        $response = $this->json('DELETE', '/api/products/delete/4848446');

        //checks if access is not found
        $response->assertStatus(404);
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
        $response = $this->json('DELETE', '/api/products/delete/'.$product->id);

        //checks if deleted
        $response->assertJson(["message" => "Produto deletado."]);
        $response->assertStatus(200);
    }
}
