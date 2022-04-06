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

    public function myZonas()
    {
        return response()->json(auth()->user()->zonas,200);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ZonaRequest $request)
    {
        $zona = new Zona;
        $zona->nombre = $request->nombre;
        $zona->descripcion = $request->descripcion;
        $zona->user_id = auth()->user()->id;
        if($request->hasFile('portada_img')){
            $portada = $request->file('portada_img');
            if (!is_array($portada)) {
                $portada = [$portada];
            }
            $custom_name = 'img-' . Str::uuid()->toString() . '.' . $portada[0]->getClientOriginalExtension();
            $portada[0]->move(public_path() . '/zonas', $custom_name);
            $zona->portada_img = $custom_name;
        }

        $zona->save();
        return response()->json($zona, 201);
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
    public function validateAction($user_id){
        return $user_id===auth()->user()->id || auth()->user()->id_rol===1;
    }
}
