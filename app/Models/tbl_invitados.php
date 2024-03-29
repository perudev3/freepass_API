<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class tbl_invitados extends Model
{
    protected $fillable = [  
        'user_id',
        'status',
        'lista_codes_id',
    ];

    protected $primaryKey ="invitados_id";


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id' , 'id')->where('id_rol', 5);
    }
}
