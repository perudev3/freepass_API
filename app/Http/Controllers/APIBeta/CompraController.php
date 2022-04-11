<?php

namespace App\Http\Controllers\APIBeta;

use App\Compra;
use App\Http\Controllers\Controller;
use App\Invitado;
use App\Lista;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class CompraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $lista=Lista::findOrFail($request->lista_id);
            $invitados=json_decode(json_encode($request->invitados));
            $totalEntradas=count($invitados)+1;
            if($lista->cantidad_disponible<$totalEntradas){
                return response()->json([
                    'message'=>'No hay suficientes entradas disponibles',
                    'status'=>'error'
                ],400);
            }
            
            $compra=Compra::create([
                'user_id'=>auth()->user()->id,
                'lista_id'=>$request->lista_id,
                'cantidad'=>$totalEntradas,
                'codigo_compra_entrada'=>Str::uuid()->toString(),
                'total_compra'=>$lista->precio*$totalEntradas,
                'status'=>0,
                'pagado'=>0
            ]);
            $lista->update([
                'cantidad_disponible'=>$lista->cantidad_disponible-$totalEntradas,
            ]);
            foreach ($invitados as $invitado) {
                Invitado::create([
                    'compra_id'=>$compra->id,
                    'nombre'=>$invitado->nombre,
                    'apellido'=>$invitado->apellido,
                    'dni'=>$invitado->dni,
                    'email'=>$invitado->email,
                    'telefono'=>$invitado->telefono,
                    'codigo_invitacion'=>Str::uuid()->toString(),
                    'status'=>0
                ]);
            }
            DB::commit();
            return response()->json([
                'message'=>'Compra realizada con exito',
                'status'=>'success'
            ],201);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'message'=>'Error al realizar la compra',
                'status'=>'error'
            ],400);
        }
       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Compra  $compra
     * @return \Illuminate\Http\Response
     */
    public function show(Compra $compra)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Compra  $compra
     * @return \Illuminate\Http\Response
     */
    public function edit(Compra $compra)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Compra  $compra
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Compra $compra)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Compra  $compra
     * @return \Illuminate\Http\Response
     */
    public function destroy(Compra $compra)
    {
        //
    }
}
