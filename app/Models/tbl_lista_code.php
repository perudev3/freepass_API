<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\tbl_invitados;
use App\Models\tbl_restaurante;

class tbl_lista_code extends Model
{
    protected $fillable = [
        'nombre',
        'codigo_invitacion',
        'listas_id',
        'restaurantes_id',
    ];

    protected $primaryKey ="lista_codes_id";

    public function invitados()
    {
        return $this->hasMany(tbl_invitados::class, 'lista_codes_id' , 'lista_codes_id');
    }

    public function data_restaurante()
    {
        return $this->hasMany(tbl_restaurante::class, 'restaurantes_id' , 'restaurantes_id');
    }
}
