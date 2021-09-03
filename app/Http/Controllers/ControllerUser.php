<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ControllerUser extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       try {
        $this->validate($request, [
            'name'     => 'string|required',
            'email'    => 'email|required',
            'password' => 'required'
        ]);

        $user = new User;
        $user->name      = $request->name;
        $user->email     = $request->email;
        $user->password  = Hash::make($request->password);
        $user->save();

        return response()->json(['success' => 'Usuário criado com sucesso!!'], 201);
       } catch (Exception $exception) {

        if (isset($exception->errorInfo[1]) && $exception->errorInfo[1] == 1062)
            return response()->json(['error' => 'Usuário já cadastrado'], 401);

        return response()->json(['error' => 'Falha ao incluir o usuário na base de dados.'], 401);
       }
    }
}
