<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Venta;
use App\Models\Unidad;

class Articulo extends Model
{
    use HasFactory;

    protected $table = 'Articulo';
    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'Modelo',
        'Descripcion',
        'Costo',
        'PrecioVenta',
        'Peso',
        'Stock',
        'Largo',
        'Alto',
        'Ancho',
        'fk_id_unidad'
    ];

    public function ventas()
    {
        return $this -> belongsToMany(
            Venta::class,
            'fk_id_articulo',
            'fk_id_Ventas'
        ) -> withPivot('cantidad');
    }

    public function unidad(): BelongsTo
    {
        //(fk de Unidad, pk de Unidad)
        return $this -> belongsTo(Unidad::class, 'fk_id_unidad', 'id');
    }
}
