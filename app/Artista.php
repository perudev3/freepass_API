<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Artista extends Model
{
    protected $fillable = ['nombre','descripcion','foto','evento_id'];
}
