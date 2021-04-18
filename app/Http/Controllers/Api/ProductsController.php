<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Products;
use App\Http\Controllers\Controller;
use App\Http\Requests\Products\AddProductRequest;
use App\Http\Requests\Products\UpdateProductRequest;

class ProductsController extends Controller
{
    /**
     * index method
     * route: /products
     * This method lists 1 or 'n' products. You can add filters in search
     * @return Response
     */
    public function index(Request $request)
    {
        $products = Products::filters($request);

        if (isset($request->items_per_page))
            return $products->paginate($request->items_per_page);

        return $products->paginate(20);
    }

    /**
     * add method
     * route: /products/add
     * @param  AddProductRequest  $request
     * This method create a new product
     * @return Response
     */
    public function add(AddProductRequest $request)
    {
        $product_data = array_merge($request->all(), ["id_user_created" => Auth::id()]);
        $product = Products::create($product_data);

        if (isset($product->id))
            return response()->json(['message' => 'Produto Criado', 'product' => $product], 200);
        else
            return response()->json(['error' => 'Sem permissão para criar o produto'], 401);
    }

    /**
     * update method
     * route: /products/update
     * This method updates a specific product
     * @param  Request  $request
     * @param  string  $id
     * @return Response
     */
    public function update(UpdateProductRequest $request, $id_product)
    {
        $product = Products::find($id_product);

        if(!isset($product->id))
            return response()->json(['error' => 'Produto não encontrado'], 404);

        $product_data = array_merge($request->all(), ["id_user_updated" => Auth::id()]);

        if($product->update($product_data))
            return response()->json(['message' => 'Produto atualizado', 'product' => $product], 200);
        else
            return response()->json(['error' => 'Sem permissão para atualizar o produto'], 401);
    }

    /**
     * delete method
     * route: /products/delete
     * This method deletes a specific product
     * @param  string  $id
     * @return Response
     */
    public function delete($id_product)
    {
        $product = Products::find($id_product);

        if (!isset($product->id))
            return response()->json(['error' => 'Produto não encontrado'], 404);

        if ($product->update(['deleted_at' => Carbon::now(), 'id_user_deleted' => Auth::id()]))
            return response()->json(['message' => 'Produto deletado.'], 200);
        else
            return response()->json(['error' => 'Sem permissão para excluir o produto'], 401);
    }
}
