<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImagePlace extends Model
{
    protected $table = 'image_places';
    protected $fillable = ['place_id','image_path'];
}
