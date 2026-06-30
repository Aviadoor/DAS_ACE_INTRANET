<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Venta;
use App\Models\Boleta;
use App\Models\Tipo_Documento;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Personal extends Model
{
    use HasFactory;

    protected $table = 'Personal';
    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'Nombre_1',
        'Nombre_2',
        'Apellido_1',
        'Apellido_2',
        'telefono',
        'Codigo_Documento',
        'fk_id_tipo_documento'
    ];

    //Un personal puede tener muchas boletas
    public function boletas(): HasMany 
    {
        //(fk de Personal, pk de Personal)
        return $this -> hasMany(Boleta::class, 'fk_id_personal', 'id');    
    }

    //Un personal puede tener muchas ventas
    public function ventas(): HasMany
    {
        //(fk de Personal, pk de Personal)
        return $this -> hasMany(Venta::class, 'fk_personal_Vendedor', 'id');
    }

    public function documento(): BelongsTo
    {
        return $this -> belongsTo(Tipo_Documento::class, 'fk_id_tipo_documento', 'id');
    }

}
