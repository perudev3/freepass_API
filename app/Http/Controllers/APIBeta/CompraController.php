<?php

namespace App\Http\Controllers\APIBeta;

use App\Compra;
use App\Comprobante;
use App\Evento;
use App\Http\Controllers\Controller;
use App\Invitado;
use App\Lista;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CompraController extends Controller
{
    //construct
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function index()
    {
        $compras = Compra::with('comprobante')->latest()->paginate(10);
        return response()->json($compras);
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
            $lista = Lista::findOrFail($request->lista_id);
            $invitados = json_decode(json_encode($request->invitados));
            $totalEntradas = count($invitados) + 1;
            if ($lista->cantidad_disponible < $totalEntradas) {
                return response()->json([
                    'message' => 'No hay suficientes entradas disponibles',
                    'status' => 'error'
                ], 400);
            }

            $compra = Compra::create([
                'user_id' => auth()->user()->id,
                'lista_id' => $request->lista_id,
                'cantidad' => $totalEntradas,
                'codigo_compra_entrada' => Str::uuid()->toString(),
                'total_compra' => $lista->precio * $totalEntradas,
                'status' => 0,
                'pagado' => 0
            ]);
            $lista->update([
                'cantidad_disponible' => $lista->cantidad_disponible - $totalEntradas,
            ]);
            foreach ($invitados as $invitado) {
                Invitado::create([
                    'compra_id' => $compra->id,
                    'nombre' => $invitado->nombre,
                    'apellido' => $invitado->apellido,
                    'dni' => $invitado->dni,
                    'email' => $invitado->email,
                    'telefono' => $invitado->telefono,
                    'codigo_invitacion' => Str::uuid()->toString(),
                    'status' => 0
                ]);
            }
            DB::commit();
            return response()->json([
                'message' => 'Compra realizada con exito',
                'status' => 'success',
                'compra' => $compra->id
            ], 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error al realizar la compra',
                'status' => 'error',
                'error' => $th->getMessage()
            ], 400);
        }
    }
    public function enviarComprobante(Request $request)
    {
        $imagenes = $request->file('img_comprobante');
        if (!is_array($imagenes)) {
            $imagenes = [$imagenes];
        }
        //loop throu the array 
        $file = $imagenes[0];
        $custom_name = 'img-' . Str::uuid()->toString() . '.' . $file->getClientOriginalExtension();
        Comprobante::create([
            'img_comprobante' => $custom_name,
            'compra_id' => $request->compra_id
        ]);
        $file->move(public_path() . '/comprobantes', $custom_name);

        return response()->json(['message' => 'comprobante cargado espere su activación'], 200);
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
    public function aprobarCompra($id)
    {
        $compra=Compra::findOrFail($id);
        if(!$compra->hasComprobante()){
            return response()->json([
                'message' => 'La compra no cuenta con un comprobante para ser aprobado',
                'status' => 'error'
            ], 400);
        }
        if ($compra->pagado == 1) {
            return response()->json([
                'message' => 'La compra ya fue aprobada',
                'status' => 'error'
            ], 400);
        }
        $compra->update([
            'pagado' => 1
        ]);
        return response()->json([
            'message' => 'Compra aprobada con exito',
            'status' => 'success'
        ], 200);
    }

    public function verificarEntrada(Request $request){
        if(!Evento::find($request->evento_id)){
            return response()->json([
                'message' => 'El evento no existe',
                'status' => 'error'
            ], 400);
        }
        $evento=Evento::find($request->evento_id);
        if ($evento->fecha < now()->toDateString()) {
            return response()->json([
                'message' => 'El evento ya ha finalizado',
                'status' => 'error'
            ], 400);
        }
        if ($evento->status == 0) {
            return response()->json([
                'message' => 'El evento no esta activo',
                'status' => 'error'
            ], 400);
        }
        
        if(Compra::where('codigo_compra_entrada',$request->codigo)->first()){
            $compra=Compra::where('codigo_compra_entrada',$request->codigo)->first();
            if($compra->pagado==0){
                return response()->json([
                    'message' => 'La compra no ha sido aprobada',
                    'status' => 'error'
                ], 400);
            }
            if($compra->status==1){
                return response()->json([
                    'message' => 'La entrada ya fue usada',
                    'status' => 'error'
                ], 400);
            }
            $compra->update([
                'status' => 1
            ]);
            return response()->json([
                'message' => 'Entrada verificada con exito',
                'beneficiario'=>$compra->user,
                'status' => 'success'
            ], 200);
        }
        if(Invitado::where('codigo_invitacion',$request->codigo)->first()){
            $invitado=Invitado::where('codigo_invitacion',$request->codigo)->first();
            if($invitado->compra->pagado==0){
                return response()->json([
                    'message' => 'La compra no ha sido aprobada',
                    'status' => 'error'
                ], 400);
            }
            if($invitado->status==1){
                return response()->json([
                    'message' => 'La entrada ya fue usada',
                    'status' => 'error'
                ], 400);
            }
            $invitado->update([
                'status' => 1
            ]);
            return response()->json([
                'message' => 'Entrada verificada con exito',
                'beneficiario'=>$invitado,
                'status' => 'success'
            ], 200);
        }
        return response()->json([
            'message' => 'El codigo de entrada no existe',
            'status' => 'error'
        ], 400);
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
