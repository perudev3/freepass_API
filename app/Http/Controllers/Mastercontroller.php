<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;


class Mastercontroller extends Controller
{
  
    public function CrearSuperUsuario(Request $request)
    {
        $user = \Auth::user();
        if ($user->id_rol==1) {
            $validator = \Validator::make($request->all(),[
                    'name' => 'required',
                    'email' => 'required',
                    'password' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 401);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'id_rol'=> 2,
            ]);

            if ($user==true) {
                return [ 'status' =>'success', 'message' => 'Se a creado el usuario'];
            }else{
                return [ 'status' =>'error', 'message' => 'No se pudo crear el usuario'];
            }
        }else{
            return ['message' => 'no autorizado'];
        }
    }

}
