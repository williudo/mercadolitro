<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Products;
use App\Http\Controllers\Controller;

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
        //Validate request
        $this->validate($request, [
            'items_per_page' => 'numeric|min:1|max:100',
        ]);
        //get products with filters
        $products = Products::filters($request);
        //check if query of number of pages
        if(isset($request->items_per_page))
            return $products->paginate($request->items_per_page);

        return $products->paginate(20);
    }

    /**
     * add method
     * route: /products/add
     * @param  Request  $request
     * This method create a new product
     * @return Response
     */
    public function add(Request $request)
    {
        //Validate request
        $this->validate($request, [
            'name' => 'required|string|max:30',
            'description' => 'required|max:50|string',
            'quantity' => 'required|numeric|min:0',
            'price' => 'required|numeric',
            'color' => 'nullable|in:blue,red,green,purple,yellow,brown,black,white,magenta,grey,'
        ]);
        //Create product
        $product_data = array_merge($request->all(), ["id_user_created" => Auth::id()]);
        $product = Products::create($product_data);
        //check product creation
        if(isset($product->id))
            return response()->json(['message' => 'Product created', 'product' => $product], 200);
        else
            return response()->json(['error' => 'Product Creation not permitted'], 401);
    }

    /**
     * update method
     * route: /products/update
     * This method updates a specific product
     * @param  Request  $request
     * @param  string  $id
     * @return Response
     */
    public function update(Request $request, $id_product)
    {
        //Validate request
        $this->validate($request, [
            'name' => 'required|string|max:30',
            'description' => 'required|max:50|string',
            'quantity' => 'required|numeric|min:0',
            'price' => 'required|numeric',
            'color' => 'nullable|in:blue,red,green,purple,yellow,brown,black,white,magenta,grey'
        ]);
        //Find product
        $product = Products::find($id_product);
        //check product found
        if(!isset($product->id))
            return response()->json(['error' => 'Product not found'], 404);

        //retrieving data
        $product_data = array_merge($request->all(), ["id_user_updated" => Auth::id()]);
        //updates product, and check changes
        if($product->update($product_data))
            return response()->json(['message' => 'Product updated', 'product' => $product], 200);
        else
            return response()->json(['error' => 'Product update not permitted'], 401);
    }

    /**
     * delete method
     * route: /products/delete
     * This method deletes a specific product
     * @param  Request  $request
     * @param  string  $id
     * @return Response
     */
    public function delete(Request $request, $id_product)
    {
        //Find prodcut or throws 404 error
        $product = Products::find($id_product);
        //check product found
        if(!isset($product->id))
            return response()->json(['error' => 'Product not found'], 404);
        //updates product, and check changes
        if($product->update(['deleted_at' => Carbon::now(), 'id_user_deleted' => Auth::id()]))
            return response()->json(['message' => 'Product deleted'], 200);
        else
            return response()->json(['error' => 'Product delete not permitted'], 401);
    }
}
