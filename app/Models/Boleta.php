<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Personal;

class Boleta extends Model
{
    use HasFactory;

    protected $table = 'Boleta';
    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'Dias_Laborados',
        'Prima_Seguro',
        'Sueldo_Neto',
        'Total_Horas',
        'Fecha_Inicio',
        'Sueldo_Bruto',
        'fk_id_personal'
    ];

    public function personal(): BelongsTo
    {
        return $this -> belongsTo(Personal::class, 'fk_id_personal', 'id');
    }
}
