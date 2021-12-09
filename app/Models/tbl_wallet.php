<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\User;

class tbl_wallet extends Model
{
    protected $fillable = [
        'wallet_fecha',
        'wallet_monto',
        'user_id'
    ];

    protected $primaryKey ="wallet_id";

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id' , 'id'); 
    }
}
