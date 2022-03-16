<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Models\tbl_roles;
use App\Models\tbl_categoria;

class Mastercontroller extends Controller
{
    public function ComerciosUsuariosLista()
    {
        $user = \Auth::user();
        if ($user->id_rol==1) {
            return User::with('Roles')->where('id_rol', 3)->get();
        }else{
            return ['message' => 'no autorizado'];
        }
        
    }

    public function SuperUsuariosLista()
    {
        $user = \Auth::user();
        if ($user->id_rol==1) {
            return User::with('Roles')->where('id_rol', 2)->get();
        }else{
            return ['message' => 'no autorizado'];
        }
        
    }

    public function RolesCategoriasMaster()
    {
        $user = \Auth::user();
        if ($user->id_rol==1) {
            return [
                'roles' => tbl_roles::all(),
                'categorias' => tbl_categoria::all(),
            ];
        }else{
            return ['message' => 'no autorizado'];
        }
        
    }

    public function CrearComercioUsuario(Request $request)
    {
        $user = \Auth::user();
        if ($user->id_rol==1) {
            $validator = \Validator::make($request->all(),[
                    'name' => 'required',
                    'email' => 'required',
                    'password' => 'required',
                    'rol' => 'required',
                    'categoria' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 401);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'id_rol'=> $request->rol,
                'categorias_id' => $request->categoria
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


    public function SearchUsuario(Request $request)
    {
        $user = \Auth::user();
        if ($user->id_rol==1) {
            return User::with('Roles')->where('id_rol', $request->roles_id)->get();
        }else{
            return ['message' => 'no autorizado'];
        }
    }


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
