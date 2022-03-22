<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class RestaurantsCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data'=>$this->collection->map(function($restaurante){
                return [
                    'id'=>$restaurante->restaurantes_id,
                    'nombre'=>$restaurante->nombre,
                    'slug'=>$restaurante->nombre_slug,
                    'razon_social'=>$restaurante->razon_social,
                    'direccion'=>$restaurante->direccion,
                    'telefono'=>$restaurante->telefono,
                    'lat'=>$restaurante->lat,
                    'lng'=>$restaurante->lng,
                    'foto_perfil'=>$restaurante->foto_perfil,
                    'ruc'=>$restaurante->ruc,
                    'usuario'=>$restaurante->user()->get(['id','name','telefono'])->first(),
                    'pais'=>$restaurante->pais()->get(['pais_id','pais_nombre'])->first(),
                    'ciudad'=>$restaurante->ciudades()->get(['ciudades_id','ciudades_nombre'])->first(),
                    'categoria'=>$restaurante->categoria()->get(['categorias_id','categorias_nombre'])->first(),
                    'img_restaurantes'=>$restaurante->img_restaurantes()->get(['img_restaurantes_id','url_img'])->first(),
                    'estado'=>$restaurante->estado
                ];
            }),
            'author'=>'Lara-net'
        ];
    }
}
