<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tbl_roles extends Model
{
    protected $fillable = [
        'roles_name'
    ];

    protected $primaryKey ="roles_id";
}
