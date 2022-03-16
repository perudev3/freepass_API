<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\img_restaurante;
use App\Models\tbl_pais;
use App\Models\tbl_ciudades;
use App\Models\tbl_eventos;
use App\Models\tbl_zonas;
use App\User;

class tbl_restaurante extends Model
{
    protected $fillable = [
        'nombre',
        'nombre_slug',
        'razon_social',
        'direccion',
        'telefono',
        'lat',
        'lng',
        'foto_perfil',
        'ruc',
        'user_id',
        'pais_id',
        'categorias_id',
        'ciudades_id',
    ];

    protected $primaryKey ="restaurantes_id";


    public function img_restaurantes()
    {
        return $this->hasMany(img_restaurante::class, 'restaurantes_id' , 'restaurantes_id'); 
    }

    public function pais()
    {
        return $this->belongsTo(tbl_pais::class, 'pais_id' , 'pais_id'); 
    }

    public function ciudades()
    {
        return $this->belongsTo(tbl_ciudades::class, 'ciudades_id' , 'ciudades_id'); 
    }

    public function eventos()
    {
        return $this->hasMany(tbl_eventos::class, 'restaurantes_id' , 'restaurantes_id');
    }

    public function zonas()
    {
        return $this->hasMany(tbl_zonas::class, 'restaurantes_id' , 'restaurantes_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id' , 'id');
    }

    public function categoria()
    {
        return $this->belongsTo(tbl_categoria::class, 'categorias_id' , 'categorias_id');
    }
    public static function search($nombre){
        return $this->where('nombre', 'like', '%'.$nombre.'%')->get();
    }
}
