<?php

namespace App\Http\Controllers\APIBeta;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlaceRequest;
use App\Image;
use App\Place;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PlaceController extends Controller
{
    //constructor 
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function index()
    {
        $places = auth()->user()->places()->paginate();
        return response()->json($places, 200);
    }


    public function store(PlaceRequest $request)
    {
        $place = auth()->user()->places()->create($request->all());
        if ($request->hasFile('images')) {
            $images = $request->file('images');
            if (!is_array($images)) {
                $images = [$images];
            }
            foreach ($images as $image) {
                $custom_name = 'img-' . Str::uuid()->toString() . '.' . $image->getClientOriginalExtension();
                $place->imagenes()->create([
                    'image_path' => $custom_name,
                ]);
                $image->move(public_path() . '/eventos', $custom_name);
            }
            
        }
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
        if ($this->validatePlace()) {
            $place = Place::findOrfail($id)->load('imagenes');
            return response()->json($place, 200);
        }
        return response()->json(['error' => 'No tiene los permisos para ver este recurso'], 404);
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
        if ($this->validatePlace()) {
            $place->update($request->all());
            return response()->json(['status' => 'success', 'message' => 'Se Actualizó correctamente'], 200);
        }
        return response()->json(['status' => 'error', 'message' => 'No tiene los permisos necesarios'], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function destroy(Place $place)
    {
        if ($this->validatePlace()) {
            $place->delete();
            return response()->json(['status' => 'success', 'message' => 'Se Eliminó correctamente'], 200);
        }
        return response()->json(['status' => 'error', 'message' => 'No tiene los permisos necesarios'], 404);
    }

    public function validateAction($user_id)
    {
        return $user_id === auth()->user()->id || auth()->user()->id_rol === 1;
    }
}
