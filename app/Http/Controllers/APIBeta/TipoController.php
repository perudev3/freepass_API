<?php

namespace App\Http\Controllers\APIBeta;

use App\Evento;
use App\Http\Controllers\Controller;
use App\Tipo;
use Illuminate\Http\Request;

class TipoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['index','show']);
    }

    public function index()
    {
        $tipos=Tipo::select(['id','nombre'])->get();
        return response()->json($tipos,200);
    }

  

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre'=>'required|unique:tipos|max:255',
        ]);
        Tipo::create(['nombre'=>$request->nombre]);
        return response()->json(['message'=>'Tipo de evento creado correctamente'],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $eventos=Evento::whereEvents()->where('tipo_id',$id)->paginate(10);
        return response()->json($eventos,200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tipo $tipo)
    {
        $request->validate([
            'nombre'=>'required|unique:tipos|max:255',
        ]);
        $tipo->update($request->all());
        return response()->json(['message'=>'Tipo de evento actualizado correctamente'],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tipo $tipo)
    {
        $tipo->delete();
        return response()->json(['message'=>'Tipo de evento eliminado correctamente'],200);
    }
}
