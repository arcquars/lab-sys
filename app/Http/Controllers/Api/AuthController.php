<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * POST /api/auth/login
     * Recibe email/password. Si las credenciales son válidas, el usuario está
     * activo y pertenece al rol 'admin', genera un nuevo api_token y lo
     * devuelve. Los tokens anteriores del mismo usuario quedan invalidados.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->input('email'))->first();

        if (! $user || ! Hash::check($request->input('password'), $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Credenciales inválidas.'],
            ]);
        }

        if (! $user->active) {
            return response()->json(['message' => 'Usuario inactivo.'], 403);
        }

        if (! $user->hasRole('admin')) {
            return response()->json(['message' => 'No autorizado para emitir tokens API.'], 403);
        }

        $user->forceFill([
            'api_token' => Str::random(60),
        ])->save();

        return response()->json([
            'token' => $user->api_token,
            'user'  => [
                'id'    => $user->id,
                'name'  => $user->name,
                'email' => $user->email,
            ],
        ]);
    }

    /**
     * POST /api/auth/logout
     * Protegido por middleware auth:api. Revoca el token del usuario
     * autenticado seteando api_token a NULL.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $user = $request->user('api');

        if ($user) {
            $user->forceFill(['api_token' => null])->save();
        }

        return response()->json(['message' => 'Token revocado.']);
    }
}
