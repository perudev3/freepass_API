<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\tbl_ciudades;

class tbl_pais extends Model
{
    protected $fillable = [
        'pais_nombre'
    ];

    protected $primaryKey ="pais_id";


    public function ciudades()
    {
        return $this->hasMany(tbl_ciudades::class, 'pais_id' , 'pais_id'); 
    }
}
