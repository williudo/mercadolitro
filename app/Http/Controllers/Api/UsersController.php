<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    /**
     * index method
     * route: /users
     * This method lists 1 or 'n' users. You can add filters in search
     * @return Response
     */
    public function index(Request $request)
    {
        //Validate request
        $this->validate($request, [
            'items_per_page' => 'numeric|min:1|max:100',
        ]);
        //get users with filters
        $users = User::filters($request);
        //check if query of number of pages
        if(isset($request->items_per_page))
            return $users->paginate($request->items_per_page);

        return $users->paginate(20);
    }

    /**
     * add method
     * route: /users/add
     * @param  Request  $request
     * This method create a new user
     * @return Response
     */
    public function add(Request $request)
    {
        //Validate request
        $this->validate($request, [
            'name' => 'required|string|max:50',
            'email' => 'required|email|max:50|unique:users,email,NULL,id,deleted_at,NULL',
            'password' => 'required|string|min:6|confirmed',
        ]);
        //Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'id_user_created' => Auth::id()
        ]);
        //check user creation
        if(isset($user->id))
            return response()->json(['message' => 'User created', 'user' => $user], 200);
        else
            return response()->json(['error' => 'User Creation not permitted'], 401);
    }

    /**
     * update method
     * route: /users/update
     * This method updates a specific user
     * @param  Request  $request
     * @param  string  $id
     * @return Response
     */
    public function update(Request $request, $id_user)
    {
        //Validate request
        $this->validate($request, [
            'name' => 'required|string|max:50',
            'email' => 'required|email|max:50|unique:users,email,'.$id_user.',id,deleted_at,NULL',
            'password' => 'confirmed|nullable|min:6',
        ]);
        //Find user
        $user = User::find($id_user);
        //check user found
        if(!isset($user->id))
            return response()->json(['error' => 'User not found'], 404);

        //retrieving data
        $request_user_data = $request->only(['name', 'email', 'password']);
        $request_user_data['id_user_updated'] = Auth::id();
        //Hashing password
        $request_user_data['password'] = Hash::make($request->password);
        //updates user, and check changes
        if($user->update($request_user_data))
            return response()->json(['message' => 'User updated', 'user' => $user], 200);
        else
            return response()->json(['error' => 'User update not permitted'], 401);
    }

    /**
     * delete method
     * route: /users/delete
     * This method deletes a specific user
     * @param  Request  $request
     * @param  string  $id
     * @return Response
     */
    public function delete(Request $request, $id_user)
    {
        //Find user
        $user = User::find($id_user);
        //check user found
        if(!isset($user->id))
            return response()->json(['error' => 'User not found'], 404);
        //updates user, and check changes
        if($user->update(['deleted_at' => Carbon::now(), 'id_user_deleted' => Auth::id()]))
            return response()->json(['message' => 'User deleted'], 200);
        else
            return response()->json(['error' => 'User delete not permitted'], 401);
    }
}
