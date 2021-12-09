<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class img_restaurante extends Model
{
    protected $fillable = [
        'url_img',
        'restaurantes_id'
    ];

    protected $primaryKey ="img_restaurantes_id";
}
