<?php

namespace App\Http\Controllers\APIBeta;

use App\Evento;
use App\Http\Controllers\Controller;
use App\Http\Requests\EventoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EventoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['index', 'show', 'lastEvents', 'searchEventsTipos', 'searchEvents']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $eventos = Evento::whereEvents()->paginate(10);
        return response()->json($eventos, 200);
    }

    public function lastEvents(Request $request)
    {
        $eventos = Evento::whereEvents()->take($request->cantidad)->get();
        return response()->json($eventos, 200);
    }
    public function searchEvents(Request $request)
    {
        $eventos = Evento::whereEvents()->where($request->campo, 'like', '%' . $request->valor . '%')->paginate(10);
        return response()->json($eventos, 200);
    }
    public function searchEventsTipos(Request $request)
    {
        $eventos = Evento::whereEvents()->whereIn('tipo_id', $request->tipos)->paginate(10);
        return response()->json($eventos, 200);
    }
    public function show($id)
    {
        $evento = Evento::findOrFail($id)->load('tipo');
        return response()->json($evento, 200);
    }


    public function store(EventoRequest $request)
    {

        $portada = $request->file('portada_img');
        $cont = 0;
        foreach ($portada as $img) {
            $custom_name = 'img-' . Str::uuid()->toString() . '.' . $img->getClientOriginalExtension();
            if ($cont === 0) {
                $evento = Evento::create([
                    'nombre' => $request->nombre,
                    'tipo_id' => $request->tipo_id,
                    'fecha' => $request->fecha,
                    'hora_inicio' => $request->hora_inicio,
                    'hora_fin' => $request->hora_fin,
                    'lugar' => $request->lugar,
                    'portada_img' => $custom_name,
                    'descripcion' => $request->descripcion,
                    'numero_promotor' => $request->numero_promotor,
                ]);
            } else {
                break;
            }
            $img->move(public_path() . '/eventos', $custom_name);

            $cont++;
        }
        if ($evento == true) {
            return ['status' => 'success', 'message' => 'Se Registró correctamente'];
        } else {
            return ['status' => 'error', 'message' => 'Ocurrio un Error'];
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EventoRequest $request, Evento $evento)
    {
        $portada = $request->file('portada_img');
        $cont = 0;
        foreach ($portada as $img) {
            $custom_name = 'img-' . Str::uuid()->toString() . '.' . $img->getClientOriginalExtension();
            if ($cont === 0) {
                $evento = $evento->update([
                    'nombre' => $request->nombre,
                    'tipo_id' => $request->tipo_id,
                    'fecha' => $request->fecha,
                    'hora_inicio' => $request->hora_inicio,
                    'hora_fin' => $request->hora_fin,
                    'lugar' => $request->lugar,
                    'portada_img' => $custom_name,
                    'descripcion' => $request->descripcion,
                    'numero_promotor' => $request->numero_promotor,
                ]);
            } else {
                break;
            }
            $img->move(public_path() . '/eventos', $custom_name);

            $cont++;
        }
        if ($evento == true) {
            return response()->json($evento, 200);
        } else {
            return ['status' => 'error', 'message' => 'hubo un Error'];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Evento $evento)
    {
        $evento->update(['status' => !$evento->status]);
        $message = $evento->status ? 'Evento activado' : 'Evento cancelado';
        return response()->json(['message' => $message]);
    }

    public function zonasEvento(Evento $evento)
    {
        return response()->json($evento->zonas, 200);
    }
}
