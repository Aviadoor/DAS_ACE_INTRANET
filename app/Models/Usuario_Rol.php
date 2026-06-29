<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario_Rol extends Model
{
    use HasFactory;

    protected $table = 'Usuarios_Roles';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public $fillable = [
        'fk_id_usuario',
        'fk_id_rol'
    ];
}
