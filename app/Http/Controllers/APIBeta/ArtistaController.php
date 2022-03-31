<?php

namespace App\Http\Controllers\APIBeta;

use App\Artista;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ArtistaRequest;
use Illuminate\Support\Str;

class ArtistaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    
    public function store(ArtistaRequest $request)
    {
        $foto = $request->file('foto');
        $cont = 0;
        foreach ($foto as $img) {
            $custom_name = 'img-' . Str::uuid()->toString() . '.' . $img->getClientOriginalExtension();
            if ($cont === 0) {
                $artista = Artista::create([
                    'nombre' => $request->nombre,
                    'descripcion' => $request->descripcion,
                    'foto' => $custom_name,
                    'evento_id' => $request->evento_id,
                ]);
            } else {
                break;
            }
            $img->move(public_path() . '/artistas', $custom_name);

            $cont++;
        }
        if ($artista == true) {
            return ['status' => 'success', 'message' => 'Se Registró correctamente'];
        } else {
            return ['status' => 'error', 'message' => 'Ocurrio un Error'];
        }
    }

   
    public function update(Request $request, Artista $artista)
    {
        $foto = $request->file('foto');
        $cont = 0;
        foreach ($foto as $img) {
            $custom_name = 'img-' . Str::uuid()->toString() . '.' . $img->getClientOriginalExtension();
            if ($cont === 0) {
                $artista = $artista->update([
                    'nombre' => $request->nombre,
                    'descripcion' => $request->descripcion,
                    'foto' => $custom_name,
                    'evento_id' => $request->evento_id,
                ]);
            } else {
                break;
            }
            $img->move(public_path() . '/artista', $custom_name);

            $cont++;
        }
        if ($artista == true) {
            return response()->json($artista, 200);
        } else {
            return ['status' => 'error', 'message' => 'hubo un Error'];
        }
    }

    public function destroy($id)
    {
        $artista = Artista::findOrFail($id);
        //eliminar del storage
        $path = public_path() . '/artistas/' . $artista->path;
        if (file_exists($path)) {
            unlink($path);
        }
        $artista->delete();

        return response()->json(['message' => 'artista eliminado'], 200);
    }
}
