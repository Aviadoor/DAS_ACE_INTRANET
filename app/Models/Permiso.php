<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Rol;

class Permiso extends Model
{
    use HasFactory;

    protected $table = 'Permisos';

    public $timestamps = true;

    protected $fillable = [
        'Nombre',
        'Slug',
        'Descripcion',
        'Habilitado'
    ];

    public function roles()
    {
        return $this->belongsToMany(
            Rol::class, 
            'Roles_Permisos', 
            'fk_id_permiso',
            'fk_id_rol', 
        );
    }
}
