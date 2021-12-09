<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tbl_ciudades extends Model
{
    protected $fillable = [
        'ciudades_nombre',
        'pais_id'
    ];

    protected $primaryKey ="ciudades_id";

}
