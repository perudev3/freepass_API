<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\tbl_pais;
use App\Models\tbl_ciudades;
use App\Models\tbl_categoria;
use App\Models\tbl_restaurante;
use App\Models\tbl_zonas;
use App\Models\tbl_lista_code;
use App\Models\tbl_eventos;


class PanelController extends Controller
{
    
    public function cpanel()
    {
        $user = \Auth::user();
        $restaurante = tbl_restaurante::where('user_id', $user->id)->first();
        if ($restaurante == false) {
            return [
                'status' => 500,
                'message' => 'no existe registros'
            ];
        }else{
            if ($user->id_rol==3 || $user->id_rol==4) {
                $zonas = tbl_zonas::where('restaurantes_id', $restaurante->restaurantes_id)->get();
                $listas = tbl_lista_code::where('restaurantes_id', $restaurante->restaurantes_id)->get();
                $eventos = tbl_eventos::where('restaurantes_id', $restaurante->restaurantes_id)->get();
                return [
                    'zonas' => $zonas,
                    'listas' => $listas,
                    'eventos' => $eventos,
                ];
    
            }else{
                return ['message' => 'no autorizado'];
            }  
        }
        
    }

    public function Paises()
    {
        return tbl_pais::with('ciudades')->get();
    }

    public function Ciudades(Request $request)
    {
        return tbl_ciudades::where('pais_id',$request->pais_id)->get();
    }

    public function Categorias()
    {
        return tbl_categoria::all();
    }

    
}
