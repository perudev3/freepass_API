<?php

namespace App\Http\Controllers\APIBeta;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class InvitadoCntroller extends Controller
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
        /*$carnet_vacunacion = $request->file('carnet_vacunacion');
        if (!is_array($carnet_vacunacion)) {
            $carnet_vacunacion = [$carnet_vacunacion];
        }
        $file = $carnet_vacunacion[0];
        $custom_name = 'img-' . Str::uuid()->toString() . '.' . $file->getClientOriginalExtension();
        Image::create([
            'evento_id' => $evento_id,
            'path' => $custom_name
        ]);
        $file->move(public_path() . '/imagenes', $custom_name);

        return response()->json(['message' => 'imagenes cargada'], 200);*/
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
