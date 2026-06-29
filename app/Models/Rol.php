<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Usuario;
use App\Models\Permiso;
class Rol extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $table = 'Roles';
    public $timestamps = false;
    
    public $fillable = [
        'Rol',
        'Descripcion'
    ];

    public function usuarios()
    {
        return $this->belongsToMany(Usuario::class, 'Usuarios_Roles', 'fk_id_rol', 'fk_id_usuario');
    }

    public function permisos()
    {
        return $this->belongsToMany(Permiso::class, 'Roles_Permisos', 'fk_id_rol', 'fk_id_permiso');
    }
}
