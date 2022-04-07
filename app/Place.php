<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    protected $fillable = ['nombre', 'direccion', 'descripcion'];
    public function imagenes()
    {
        return $this->hasMany(ImagePlace::class, 'place_id');
    }
}
