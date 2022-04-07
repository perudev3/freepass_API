<?php

namespace App\Http\Controllers\APIBeta;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlaceRequest;
use App\Place;
use Illuminate\Http\Request;

class PlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $places = Place::paginate(10);

        return response()->json($places, 200);
    }

    
    public function store(PlaceRequest $request)
    {
        Place::create($request->all());
        return response()->json(['status' => 'success', 'message' => 'Se Registró correctamente'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $place = Place::findOrfail($id)->load('imagenes');
        return response()->json($place, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function edit(Place $place)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function update(PlaceRequest $request, Place $place)
    {
        $place->update($request->all());
        return response()->json(['status' => 'success', 'message' => 'Se Actualizó correctamente'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function destroy(Place $place)
    {
        $place->delete();
        return response()->json(['status' => 'success', 'message' => 'Se Eliminó correctamente'], 200);
    }
}
