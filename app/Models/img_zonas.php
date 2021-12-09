<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class img_zonas extends Model
{
    protected $fillable = [
        'url_img',
        'zonas_id'
    ];

    protected $primaryKey ="img_zonas_id";
    
}
