<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\img_zonas;

class tbl_zonas extends Model
{
    protected $fillable = [
        'nombre',
        'portada',
        'tipo_ambiente',
        'restaurantes_id'
    ];

    protected $primaryKey ="zonas_id";

    public function img_zonas()
    {
        return $this->hasMany(img_zonas::class, 'zonas_id' , 'zonas_id'); 
    }
}
