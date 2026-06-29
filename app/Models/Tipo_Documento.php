<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Personal;

class Tipo_Documento extends Model
{
    use HasFactory;

    protected $table = 'Tipo_Documento';
    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'Documento',
        'Nacionalidad',
    ];

    public function personal(): HasMany
    {
        //(fk de Tipo_Documento, pk de Tipo_Documento)
        return $this -> hasMany(Personal::class, 'fk_id_tipo_documento', 'id');
    }
}
