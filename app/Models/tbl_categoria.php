<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tbl_categoria extends Model
{
    protected $fillable = [
        'categorias_nombre',
        'img_categoria'
    ];

    protected $primaryKey ="categorias_id";

    public function restaurantes()
    {
        return $this->hasMany(tbl_restaurante::class, 'categorias_id' , 'categorias_id');
    }
}
