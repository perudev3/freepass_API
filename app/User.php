<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Models\tbl_roles;

class User extends Authenticatable
{
    use HasApiTokens,Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'telefono', 'dni', 'fecha_nac', 'provider', 'provider_id', 'id_rol', 'categorias_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function favoritos()
    {
        return $this->belongsToMany('App\Models\tbl_restaurante', 'tbl_favoritos', 'user_id', 'restaurantes_id');
    }

    public function rol()
    {
        return $this->belongsTo(tbl_roles::class, 'id_rol','roles_id');
    }
    public function eventos()
    {
        return $this->hasMany(Evento::class);
    }
    public function zonas()
    {
        return $this->hasMany(Zona::class);
    }
    public function hasRoles(array $roles){
        foreach($roles as $rol){
            if($this->rol->roles_name==$rol){
                return true;
            }
        }
        return false;
    }
}
