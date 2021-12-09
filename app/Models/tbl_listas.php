<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\tbl_invitados;
use App\Models\tbl_zonas;

class tbl_listas extends Model
{
    protected $fillable = [
        'nombre',
        'status',
        'precio',
        'cant_pases',
        'personas_x_mesa',
        'descripcion',
        'fecha_inicia',
        'hora_inicia',
        'fecha_fin',
        'hora_fin',
        'tipo_lista',
        'zonas_id',
        'eventos_id',
        'lista_codes_id',
    ];

    protected $primaryKey ="listas_id";


    public function zonas()
    {
        return $this->hasMany(tbl_zonas::class, 'zonas_id' , 'zonas_id'); 
    }

    public function invitados()
    {
        return $this->hasMany(tbl_invitados::class, 'listas_id' , 'listas_id'); 
    }
}
