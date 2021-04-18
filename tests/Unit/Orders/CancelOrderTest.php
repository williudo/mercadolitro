<?php

namespace Tests\Unit\Orders;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Orders;

class CancelOrderTest extends TestCase
{
    public function testUnauthorized()
    {
        $response = $this->json('DELETE', '/api/orders/cancel/123');
        $response->assertStatus(401);
    }

    public function testCancelInvalidOrder()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $response = $this->json('DELETE', '/api/orders/cancel/11111');

        $response->assertJsonFragment([
            'error' => 'Pedido não encontrado'
        ]);
        $response->assertStatus(404);
    }

    public function testCancelAOrderShipped()
    {
        $user = factory(User::class)->create();

        $order = factory(Orders::class)->create(['status' => 'shipped']);

        $this->actingAs($user);

        $response = $this->json('DELETE', '/api/orders/cancel/'.$order->id);

        $response->assertJsonFragment(['error' => 'O pedido não pode ser cancelado, pois já foi enviado']);
        $response->assertStatus(400);
    }

    public function testCancelAOrderWithSuccess()
    {
        $user = factory(User::class)->create();
        $order = factory(Orders::class)->create();

        $this->actingAs($user);

        $response = $this->json('DELETE', '/api/orders/cancel/'.$order->id);

        $response->assertJsonFragment(['message' => 'Pedido Cancelado']);
        $response->assertStatus(200);
    }

}
