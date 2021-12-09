<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tbl_categoria extends Model
{
    protected $fillable = [
        'categorias_nombre'
    ];

    protected $primaryKey ="categorias_id";
}
