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
        try {
            DB::beginTransaction();
            //convertir en array
            $listas=json_decode(json_encode($request->datos));
            foreach ($listas as $lista) {
               Lista::create([
                   'zona_id'=>$lista->zona_id,
                   'evento_id'=>$evento_id,
                   'nombre'=>$lista->nombre,
                   'tipo_lista'=>$lista->tipo_lista,
                   'precio'=>$lista->precio,
                   'cantidad_pases'=>$lista->cantidad_pases,
                   'cantidad_disponible'=>$lista->cantidad_disponible,
                   'descripcion'=>$lista->descripcion,
                   'status'=>1
               ]);
            }
            DB::commit();
            return response()->json(['message' => 'Listas registradas con exito'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
    		return response()->json([
                'success'=>false,
                'message'=>$e->getMessage(),
            ]);
            
    	}
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
