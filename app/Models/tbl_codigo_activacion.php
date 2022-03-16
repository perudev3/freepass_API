<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tbl_codigo_activacion extends Model
{
    protected $fillable = [
        'codigo',
    ];

    protected $primaryKey ="codigo_activacions_id";
}
