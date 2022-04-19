<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comprobante extends Model
{
    protected $fillable = ['img_comprobante','compra_id'];
    public function compra()
    {
        return $this->belongsTo(Compra::class);
    }
    
}
