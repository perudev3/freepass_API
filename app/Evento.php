<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    protected $fillable = ['nombre', 'descripcion',
    'fecha', 'hora_inicio', 'hora_fin', 'lugar', 'portada_img', 'status', 'numero_promotor','tipo_id'];

    public function tipo()
    {
        return $this->belongsTo(Tipo::class);
    }
    public static function whereEvents()
    {
        return Evento::where([['status',true],['fecha','>=',date('Y-m-d')]])->with('tipo')->orderBy('fecha','desc');
    }
    public function zonas()
    {
        return $this->belongsToMany(Zona::class,'listas','evento_id','zona_id')->withPivot('nombre','tipo_lista','precio','cantidad_pases','descripcion','status');
    }
    public function artistas()
    {
        return $this->hasMany(Artista::class);
    }
    public function imagenes()
    {
        return $this->hasMany(Image::class,'evento_id');
    }
}
