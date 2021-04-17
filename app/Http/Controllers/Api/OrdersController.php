<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Orders;
use App\Http\Controllers\Controller;
use App\Http\Requests\Orders\GetOrdersRequest;
use App\Http\Requests\Orders\ShipOrderRequest;

class OrdersController extends Controller
{
    /**
     * index method
     * route: /orders
     * This method lists 1 or 'n' orders. You can add filters in search
     * @return Response
     */
    public function index(GetOrdersRequest $request)
    {
        $orders = Orders::filters($request);

        if (isset($request->items_per_page))
            return $orders->paginate($request->items_per_page);

        return $orders->paginate(20);
    }

    /**
     * update method
     * route: /products/update
     * This method updates a specific product
     * @param  Request  $request
     * @param  string  $id
     * @return Response
     */
    public function cancel(Request $request, $id_order)
    {
        $order = Orders::find($id_order);

        if (!isset($order->id))
            return response()->json(['error' => 'Pedido não encontrado'], 404);

        if ($order->status == "shipped")
            return response()->json(['error' => 'O pedido não pode ser cancelado, pois já foi enviado'], 400);

        $order->status = "cancelled";

        if ($order->save())
            return response()->json(['message' => 'Pedido Cancelado'], 200);
        else
            return response()->json(['error' => 'Não foi possível cancelar o pedido'], 401);
    }

    /**
     * delete method
     * route: /products/delete
     * This method deletes a specific product
     * @param  ShipOrderRequest  $request
     * @param  string  $id
     * @return Response
     */
    public function ship(ShipOrderRequest $request, $id_order)
    {
        $order = Orders::find($id_order);

        if (!isset($order->id))
            return response()->json(['error' => 'Pedido não encontrado'], 404);

        if ($order->status == "cancelled")
            return response()->json(['error' => 'O pedido não pode ser enviado pois foi cancelado'], 400);

        if ($order->status == "shipped")
            return response()->json(['error' => 'O pedido não pode ser marcado enviado, pois já foi enviado'], 400);

        $order->status = "shipped";
        $order->tracking_number = $request->tracking_number;

        if ($order->save())
            return response()->json(['message' => 'Pedido enviado'], 200);
        else
            return response()->json(['error' => 'Não foi possível enviar o pedido'], 401);
    }
}
