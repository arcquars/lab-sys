<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Comentario: Retorna el usuario autenticado (típico para 'api/user').
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getUser(Request $request)
    {
        // Comentario: Mueve aquí la lógica que estaba en la Closure.
        return response()->json([
            'user' => $request->user(),
            'message' => 'User data retrieved successfully'
        ]);
    }
}
