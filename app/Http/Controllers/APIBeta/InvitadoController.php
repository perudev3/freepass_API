<?php

namespace App\Http\Controllers\APIBeta;

use App\Http\Controllers\Controller;
use App\Http\Requests\InvitadoRequest;
use App\Invitado;
use App\Lista;
use App\Mail\InvitadoCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class InvitadoController extends Controller
{
   

    public function store(Request $request)
    {
        $lista=Lista::find($request->lista_id);
        $invitados=json_decode(json_encode($request->invitados));
        $cantidad=count($invitados);
        if($cantidad<=$lista->cantidad_disponible){
            
            foreach ($invitados as $invitado) {
                if ($lista->status==1 && $lista->cantidad_disponible>0) {
                    $carnet_vacunacion = $invitado->file('carnet_vacunacion'); 
                    $custom_name = 'img-' . Str::uuid()->toString() . '.' . $carnet_vacunacion->getClientOriginalExtension();
                    $codigo='cod-'.Str::uuid()->toString().$request->dni;
                    $inv=Invitado::create([
                        'lista_id'=>$request->lista_id,
                        'nombre'=>$invitado->nombre,
                        'apellido'=>$invitado->apellido,
                        'dni'=>$invitado->dni,
                        'carnet_vacunacion'=>$custom_name,
                        'email'=>$invitado->email,
                        'telefono'=>$invitado->telefono,
                        'codigo_invitacion'=>$codigo,
                        'status'=>0,
                    ]);
                    $lista->update([
                        'cantidad_disponible'=>$lista->cantidad_disponible-1,
                    ]);
                    Mail::to($inv->email)->send(new InvitadoCode($inv));
                    $carnet_vacunacion->move(public_path() . '/carnets', $custom_name);
                    
                    return response()->json(['message' => 'Invitado registrado'], 200); 
                }
            }
        }else{
            return response()->json(['message' => 'La cantidad excede los cupos disponibles'], 200); 
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
