<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles_Permisos extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $table = 'Roles_Permisos';
    public $timestamps = true;

}
