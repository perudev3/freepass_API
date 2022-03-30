<?php

namespace App\Http\Controllers\APIBeta;

use App\Http\Controllers\Controller;
use App\Http\Requests\ZonaRequest;
use App\Zona;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ZonaController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api')->except(['index', 'show']);
    }

    public function index()
    {
        $zonas=Zona::select(['id','nombre','portada_img','descripcion'])->get();

        return response()->json($zonas,200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ZonaRequest $request)
    {
        $portada = $request->file('portada_img');
        $cont = 0;
        foreach ($portada as $img) {
            $custom_name = 'img-' . Str::uuid()->toString() . '.' . $img->getClientOriginalExtension();
            if ($cont === 0) {
                $zona = Zona::create([
                    'nombre' => $request->nombre,
                    'portada_img' => $custom_name,
                    'descripcion' => $request->descripcion,
                ]);
            } else {
                break;
            }
            $img->move(public_path() . '/zonas', $custom_name);

            $cont++;
        }
        if ($zona == true) {
            return ['status' => 'success', 'message' => 'Se Registró correctamente'];
        } else {
            return ['status' => 'error', 'message' => 'Ocurrio un Error'];
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
