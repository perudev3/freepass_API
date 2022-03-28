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
}