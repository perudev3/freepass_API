<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lista extends Model
{
    protected $fillable = ['zona_id', 'evento_id','nombre','tipo_lista','precio','cantidad_pases','cantidad_disponible','descripcion','status'];
    public function zona()
    {
        return $this->belongsTo(Zona::class);
    }
    public function evento()
    {
        return $this->belongsTo(Evento::class);
    }
}
