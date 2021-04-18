<?php

namespace Tests\Unit\Orders;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Orders;

class ShipOrderTest extends TestCase
{
    public function testUnauthorized()
    {
        $response = $this->json('PUT', '/api/orders/ship/123');
        $response->assertStatus(401);
    }

    public function testShipInvalidOrder()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $response = $this->json('PUT', '/api/orders/ship/11111', ['tracking_number' => 'PB111111111RR']);
        $response->assertStatus(404);
    }

    public function testShipWithoutTrackingNumber()
    {
        $user = factory(User::class)->create();

        $order = factory(Orders::class)->create();

        $this->actingAs($user);

        $response = $this->json('PUT', '/api/orders/ship/'.$order->id);

        $response->assertStatus(422);
    }

    public function testShipAOrderCancelled()
    {

        $user = factory(User::class)->create();

        $order = factory(Orders::class)->create(['status' => 'cancelled']);
        $this->actingAs($user);

        $response = $this->json('PUT', '/api/orders/ship/'.$order->id, ['tracking_number' => 'PB111111111RR']);

        $response->assertJsonFragment(['error' => 'O pedido não pode ser enviado pois foi cancelado']);
        $response->assertStatus(400);
    }

    public function testShipAOrderShipped()
    {
        $user = factory(User::class)->create();

        $order = factory(Orders::class)->create(['status' => 'shipped']);

        $this->actingAs($user);

        $response = $this->json('PUT', '/api/orders/ship/'.$order->id, ['tracking_number' => 'PB111111111RR']);

        $response->assertJsonFragment(['error' => utf8_decode('pedido não pode ser marcado enviado, pois ja foi enviado')]);
        $response->assertStatus(400);
    }

    public function testShipAOrderWithSuccess()
    {
        $user = factory(User::class)->create();
        $order = factory(Orders::class)->create();

        $this->actingAs($user);

        $response = $this->json('PUT', '/api/orders/ship/'.$order->id, ['tracking_number' => 'PB123456789BP']);

        $response->assertJsonFragment(['message' => 'Pedido enviado']);
        $response->assertStatus(200);
    }

}
