<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lista extends Model
{
    protected $fillable = ['zona_id', 'evento_id','nombre','tipo_lista','precio','cantidad_pases','descripcion','status'];
}
