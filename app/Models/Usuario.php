<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; 

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Personal;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Permiso;
use App\Models\Usuario_MFA_Codigos;
use Illuminate\Notifications\Notifiable;

// 3. CAMBIAMOS "extends Model" por "extends Authenticatable"
class Usuario extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    protected $table = 'Usuarios';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public $fillable = [
        'fk_id_personal',
        'Email',
        'Password',
        'Username',
        'Habilitado'
    ];
    
    // 4. AÑADIMOS este método para que Laravel sepa que tu columna de contraseña tiene la "P" mayúscula
    public function getAuthPassword()
    {
        return $this->Password;
    }

    public function persona(): BelongsTo
    {
        return $this->belongsTo(Personal::class, 'fk_id_personal', 'id');
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(
            Rol::class,
            'Usuarios_Roles',
            'fk_id_usuario',
            'fk_id_rol',
            'id',
            'id'
        );
    }

    public function hasRole($rolName)
    {
        return $this->roles()->where('Rol', $rolName)->exists();
    }

    // En tu modelo Usuario.php

    // Relación directa hacia los permisos a través de la tabla intermedia de Roles
    public function permisos()
    {
        return $this->hasManyThrough(
            Permiso::class,      // El modelo de Permisos (asegúrate de llamarlo como esté tu clase, ej: Permiso::class)
            Rol::class,             // El modelo intermedio
            'id',                   // Llave foránea en Usuarios_Roles que apunta a Usuarios (en tu caso usas la tabla pivote, pero a través de Eloquent se simplifica si pasas por el rol)
            'id',                   // Llave foránea en Roles_Permisos que apunta a Roles
            'id',                   // Llave local en Usuario
            'id'                    // Llave local en Rol
        )->join('Roles_Permisos', 'Permisos.id', '=', 'Roles_Permisos.fk_id_permiso')
        ->join('Usuarios_Roles', 'Roles.id', '=', 'Usuarios_Roles.fk_id_rol')
        ->where('Usuarios_Roles.fk_id_usuario', $this->id);
    }
    
    public function hasPermission($permissionSlug)
    {
        // Buscamos si entre todos los roles del usuario, alguno tiene el permiso con ese Slug
        return $this->roles()->whereHas('permisos', function($query) use ($permissionSlug) {
            
            // 1. Validamos que el permiso esté habilitado
            $query->where('habilitado', true) // (o 1, si tu base de datos usa enteros)
                  // 2. Agrupamos la validación del Slug específico o el admin-all
                ->where(function($q) use ($permissionSlug) {
                    $q->where('Slug', $permissionSlug)
                        ->orWhere('Slug', 'admin-all');
                });
        })->exists();
    }

    public function mfaCodes()
    {
        return $this -> hasMany(Usuario_MFA_Codigos::class, 'fk_id_usuario', 'id');
    }

    public function routeNotificationForMail($notification)
    {
        return $this -> Email;
    }
}