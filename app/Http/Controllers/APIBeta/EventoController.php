<?php

namespace App\Http\Controllers\APIBeta;

use App\Evento;
use App\Http\Controllers\Controller;
use App\Http\Requests\EventoRequest;
use Illuminate\Http\Request;

class EventoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['index','show','lastEvents']);
    }
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $eventos=Evento::whereEvents()->paginate(10);
        return response()->json($eventos,200);
    }

    public function lastEvents(Request $request){
        $eventos=Evento::whereEvents()->take($request->cantidad)->get();
        return response()->json($eventos,200);
    }
    public function searchEventsTipos(Request $request){
        $eventos=Evento::whereEvents()->whereIn('tipo_id',$request->tipos)->paginate(10);
        return response()->json($eventos,200);
    }
    public function show(Evento $evento)
    {
        $evento->load('tipo');
        return response()->json($evento,200);
    }
    

    public function store(EventoRequest $request)
    {
        $path = $request->file('portada_img')->store('eventos','public');
        $evento=new Evento($request->all());
        $evento->portada_img=$path;
        $evento->save();
        return response()->json($evento,201);
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
        $evento->update($request->all());
        if($request->hasFile('portada_img')){
            $path = $request->file('portada_img')->store('eventos','public');
            $evento->portada_img=$path;
        }
        $evento->save();
        return response()->json($evento,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Evento $evento)
    {
        $evento->update(['status'=>!$evento->status]);
        $message=$evento->status?'Evento activado':'Evento cancelado';
        return response()->json(['message'=>$message]);
    }

}
