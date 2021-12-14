<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class Mastercontroller extends Controller
{
    public function UsuariosLista()
    {
        return User::with('Roles')->where('id_rol', '!=', 1)->get();
    }
}
