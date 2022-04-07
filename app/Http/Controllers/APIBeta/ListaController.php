<?php

namespace App\Http\Controllers\APIBeta;

use App\Evento;
use App\Http\Controllers\Controller;
use App\Lista;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ListaController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api')->except('index');
    }
    public function index(Request $request)
    {
        $evento=Evento::findOrfail($request->evento_id);
        $listas=$evento->listas->load('zona','evento');
        return response()->json($listas, 200);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$evento_id)
    {
        Lista::create([
            'zona_id'=>$request->zona_id,
            'evento_id'=>$evento_id,
            'nombre'=>$request->nombre,
            'tipo_lista'=>$request->tipo_lista,
            'precio'=>$request->precio,
            'cantidad_pases'=>$request->cantidad_pases,
            'cantidad_disponible'=>$request->cantidad_disponible,
            'descripcion'=>$request->descripcion,
            'status'=>1
        ]);

        return response()->json([
            'message'=>'Lista creada con exito',
            'status'=>'success'
        ],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

   

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $lista=Lista::findOrfail($id);
        $request->validate([
            'zona_id'=>'required',
            'evento_id'=>'required',
            'nombre'=>'required',
            'tipo_lista'=>'required',
            'precio'=>'required',
            'cantidad_pases'=>'required',
            'cantidad_disponible'=>'required',
        ]);
        $lista->update($request->all());
        return response()->json(['message' => 'Lista actualizada con exito'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $lista=Lista::findOrfail($id);
        $lista->update(['status'=>!$lista->status]);
        $message=($lista->status) ? 'habilitada' : 'deshabilitada';
        return response()->json(['message' => "Lista $message con exito"], 200);
    }
}
