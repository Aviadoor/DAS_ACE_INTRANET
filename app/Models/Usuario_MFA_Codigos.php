<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario_MFA_Codigos extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table = 'Usuario_MFA_Codigos';

    public $timestamps = true;
    public $fillable = [
        'fk_id_usuario',
        'codigo',
        'expires_at',
        'codigo_usado',
    ];
}
