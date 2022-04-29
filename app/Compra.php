<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    protected $fillable = ['user_id','lista_id','codigo_compra_entrada','total_compra','status','pagado'];

    public function comprobante()
    {
        return $this->hasOne(Comprobante::class);
    }
    public function hasComprobante()
    {
        return $this->comprobante()->exists();
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
