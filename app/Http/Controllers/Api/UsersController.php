<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\AddUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Http\Requests\Users\GetUsersRequest;

class UsersController extends Controller
{
    /**
     * index method
     * route: /users
     * This method lists 1 or 'n' users. You can add filters in search
     * @return Response
     */
    public function index(GetUsersRequest $request)
    {
        $users = User::filters($request);

        if (isset($request->items_per_page))
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
    public function add(AddUserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'id_user_created' => Auth::id()
        ]);

        if (isset($user->id))
            return response()->json(['message' => 'Usuário criado.', 'user' => $user], 200);
        else
            return response()->json(['error' => 'Criação de usuário não permitida.'], 401);
    }

    /**
     * update method
     * route: /users/update
     * This method updates a specific user
     * @param  Request  $request
     * @param  string  $id
     * @return Response
     */
    public function update(UpdateUserRequest $request, $id_user)
    {
        $user = User::find($id_user);

        if(!isset($user->id))
            return response()->json(['error' => 'Usuário não encontrado.'], 404);

        $request_user_data = $request->only(['name', 'email', 'password']);
        $request_user_data['id_user_updated'] = Auth::id();

        if (!empty($request_user_data['password']))
            $request_user_data['password'] = Hash::make($request->password);

        if ($user->update($request_user_data))
            return response()->json(['message' => 'Usuário atualizado.', 'user' => $user], 200);
        else
            return response()->json(['error' => 'Atualização de usuário não permitida'], 401);
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
        $user = User::find($id_user);

        if (!isset($user->id))
            return response()->json(['error' => 'Usuário não encontrado.'], 404);

        if ($user->update(['deleted_at' => Carbon::now(), 'id_user_deleted' => Auth::id()]))
            return response()->json(['message' => 'Usuário Deletado.'], 200);
        else
            return response()->json(['error' => 'Não é permitido deletar este usuário'], 401);
    }
}
