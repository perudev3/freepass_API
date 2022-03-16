<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\tbl_restaurante;

class tbl_eventos extends Model
{
    protected $fillable = [
        'nombre',
        'descripcion',
        'fecha',
        'hora_inicio',
        'hora_fin',
        'status',
        'restaurantes_id'
    ];

    protected $primaryKey ="eventos_id";


    public function restaurante()
    {
        return $this->hasMany(tbl_restaurante::class, 'restaurantes_id' , 'restaurantes_id');
    }
}
