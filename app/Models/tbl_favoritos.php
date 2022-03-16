<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tbl_favoritos extends Model
{
    protected $fillable = [
        'user_id',
        'restaurantes_id'
    ];

    protected $primaryKey ="favoritos_id";
}
