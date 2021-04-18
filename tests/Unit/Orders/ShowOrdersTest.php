<?php

namespace Tests\Unit\Orders;

use App\Models\Clients;
use App\Models\Orders;
use App\Models\User;
use App\Models\Products;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowOrdersTest extends TestCase
{
    /**
     * Test access list of products without authentication.
     * Expects return a json with 401 - unauthorized response
     * @return void
     */
    public function testUnauthorized()
    {
        //Creates ramdoms products
        $orders = factory(Orders::class)->create();
        //make request
        $response = $this->json('GET', '/api/orders');

        //checks if access is unauthorized
        $response->assertStatus(401);
    }

    public function testListFirstPage()
    {
        //Create a ramdom user
        $user = factory(User::class)->create();
        //Creates ramdoms products
        $orders = factory(Orders::class, 10)->create();
        //acting as first user created
        $this->actingAs($user);
        //make request
        $response = $this->json('GET', '/api/orders?items_per_page=5');
        //checks if created 5 products
        $response->assertJsonFragment(['to' => 5]);
        $response->assertStatus(200);
    }

    public function testNotFoundKeywordStatusFilter()
    {
        //Creates a random user
        $user = factory(User::class)->create();
        //Creates ramdom product
        $orders = factory(Orders::class)->create();
        //acting as user created
        $this->actingAs($user);
        //make request
        $response = $this->json('GET', '/api/orders?status=asdasd');

        //checks if not found product
        $response->assertJsonFragment(['to' => null]);
        $response->assertStatus(200);
    }

    public function testKeywordStatusFilter()
    {
        //Creates a random user
        $user = factory(User::class)->create();
        //Creates ramdom product
        $orders = factory(Orders::class)->create();
        //acting as user created
        $this->actingAs($user);
        //make request
        $response = $this->json('GET', '/api/orders?status=paid');

        $response->assertStatus(200);
    }

    public function testNotFoundKeywordTrackingNumberFilter()
    {
        //Creates a random user
        $user = factory(User::class)->create();
        //Creates ramdom product
         $orders = factory(Orders::class)->create();
        //acting as user created
        $this->actingAs($user);
        //make request
        $response = $this->json('GET', '/api/orders?tracking_number=PB987789987CH');

        //checks if not found product
        $response->assertJsonFragment(['to' => null]);
        $response->assertStatus(200);
    }

    public function testKeywordTrackingNumberFilter()
    {
        //Creates a random user
        $user = factory(User::class)->create();
        //Creates ramdom product
         $orders = factory(Orders::class)->create(['tracking_number' => 'BR123456789BR']);
        //acting as user created
        $this->actingAs($user);
        //make request
        $response = $this->json('GET', '/api/orders?tracking_number=BR123456789BR');

        //checks if found product
        $response->assertJsonFragment([
            'total' => 1,
        ]);
        $response->assertStatus(200);
    }

    public function testNotFoundKeywordCliendIdFilter()
    {
        //Creates a random user
        $user = factory(User::class)->create();
        //Creates ramdom product
         $orders = factory(Orders::class)->create();
        //acting as user created
        $this->actingAs($user);
        //make request
        $response = $this->json('GET', '/api/orders?client_id=88888888');

        //checks if not found product
        $response->assertJsonFragment([
            'total' => 0,
            'data' => []
        ]);

        $response->assertStatus(200);
    }

    public function testNotFoundKeywordProductIdFilter()
    {
        //Creates a random user
        $user = factory(User::class)->create();
        //Creates ramdom product
        $orders = factory(Orders::class)->create();
        //acting as user created
        $this->actingAs($user);
        //make request
        $response = $this->json('GET', '/api/orders?product_id=9999999');

        //checks if not found product
        $response->assertJsonFragment([
            'total' => 0,
            'data' => []
        ]);

        $response->assertStatus(200);
    }

    public function testKeywordProductIdFilter()
    {
        //Creates a random user
        $user = factory(User::class)->create();
        $product = factory(Products::class)->create();
        //Creates ramdom product
        $orders = factory(Orders::class)->create(['product_id' => $product->id]);
        //acting as user created
        $this->actingAs($user);
        //make request
        $response = $this->json('GET', '/api/orders?product_id='.$product->id);

        //checks if found product
        $response->assertJsonFragment([
            'total' => 1
        ]);

        $response->assertStatus(200);
    }
}
