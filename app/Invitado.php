<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invitado extends Model
{
    protected $fillable = ['lista_id','nombre','apellido','dni','carnet_vacunacion','email','telefono','codigo_invitacion','status'];

    public function lista()
    {
        return $this->belongsTo(Lista::class,'lista_id');
    }
}
