<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipo extends Model
{
    protected $fillable = ['nombre'];

    public function eventos()
    {
        return $this->hasMany(Evento::class);
    }
}
