<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;
use App\Models\tbl_wallet;
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller
{
    /**
     * Registro de usuario
     */
    public function api_register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string'
        ]);
        
        $date = Carbon::now();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'id_rol'=> 5
        ]);

        $credentials = request(['email', 'password']);

        if (!\Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);

        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');

        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($token->expires_at)->toDateTimeString(),
            'user' => $user,
            'status' => 200,
            'message' => 'Successfully created user!'
        ]);
    }


    /**
     * Registro de comercio
     */
    public function api_register_comercio(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string',
            'categorias_id' => 'required'
        ]);

        $date = Carbon::now();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'categorias_id' => $request->categorias_id,
            'id_rol'=> 3
        ]);

        $credentials = request(['email', 'password']);

        if (!\Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);

        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');

        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($token->expires_at)->toDateTimeString(),
            'user' => $user,
            'status' => 200,
            'message' => 'Successfully created user!'
        ]);
    }

    /**
     * Inicio de sesión y creación de token
     */
    public function api_login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);

        $credentials = request(['email', 'password']);

        if (!\Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized',                
            ], 401);
                

        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');

        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($token->expires_at)->toDateTimeString(),
            'user' => $user,
            'status' => 200
        ]);
    }

    /**
     * Cierre de sesión (anular el token)
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'status' => 200,
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * Obtener el objeto User como json
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}
