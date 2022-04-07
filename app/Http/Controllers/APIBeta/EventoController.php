<?php

namespace App\Http\Controllers\APIBeta;

use App\Evento;
use App\Http\Controllers\Controller;
use App\Http\Requests\EventoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class EventoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['index', 'show', 'lastEvents', 'searchEventsTipos', 'searchEvents','zonasEvento','listArtistas']);
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
    public function myEvents()
    {
        return auth()->user()->eventos()->latest()->paginate();
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
    public function show($slug)
    {
        $evento = Evento::where('slug',$slug)->with(['tipo','artistas','zonas','listas'])->get();
        return response()->json($evento, 200);
    }


    public function store(EventoRequest $request)
    {

        $portada = $request->file('portada_img');
        if (!is_array($portada)) {
            $portada = [$portada];
        }
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
                    'lat'=>$request->lat,
                    'lng'=>$request->lng,
                    'slug'=>Str::slug($request->nombre),
                    'user_id'=>auth()->user()->id,
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
        if($this->validateAction($evento->user_id)){
            $evento->nombre=$request->nombre;
            $evento->tipo_id = $request->tipo_id;
            $evento->fecha = $request->fecha;
            $evento->hora_inicio = $request->hora_inicio;
            $evento->hora_fin = $request->hora_fin;
            $evento->lugar = $request->lugar;
            $evento->descripcion = $request->descripcion;
            $evento->numero_promotor = $request->numero_promotor;
            $evento->lat=$request->lat;
            $evento->lng=$request->lng;
            $evento->slug=Str::slug($request->nombre);
            if($request->file('portada_img')){
                $portada = $request->file('portada_img');
                if (!is_array($portada)) {
                    $portada = [$portada];
                }
                $custom_name = 'img-' . Str::uuid()->toString() . '.' . $portada[0]->getClientOriginalExtension();
                $evento->portada_img = $custom_name;
                $portada[0]->move(public_path() . '/eventos', $custom_name);
            }
            return response()->json(['message'=>"Eevento actualizado correctamente"]);
        }else{
            return response()->json(['message'=>'No tiene permisos para actualizar este evento']);
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
        if($this->validateAction($evento->user_id)){
            $evento->update(['status' => !$evento->status]);
            $message = $evento->status ? 'Evento activado' : 'Evento cancelado';
            return response()->json(['message' => $message]);
        }
        return response()->json(['message' => 'no tiene los permisos necesarios para eliminar estos registros']);
        
    }

    public function zonasEvento(Evento $evento)
    {
        return response()->json($evento->zonas, 200);
    }
    public function listArtistas(Request $request)
    {
        $artistas=Evento::findOrFail($request->evento)->artistas;
        return response()->json($artistas, 200);
    }


    public function validateAction($user_id){
        return $user_id===auth()->user()->id || auth()->user()->id_rol===1;
    }
}
