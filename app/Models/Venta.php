<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Personal;
use App\Models\Articulo;

class Venta extends Model
{
    use HasFactory;

    protected $table = 'Ventas';
    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'Nombre_Cliente',
        'fk_personal_Vendedor',
        'Fecha_Emision',
        'Fecha_Entrega',
        'Fecha_Cobro',
        'Subtotal',
        'Total',
        'MontoCancelado',
        'Cuotas'
    ];

    //Una venta pertenece a un personal
    public function personal(): BelongsTo
    {
        //(fk de personal, pk de personal)
        return $this -> belongsTo(Personal::class, 'fk_personal_Vendedor', 'id');
    }

    //Una venta tiene x cantidad de un articulo
    public function articulos()
    {
        return $this -> belongsToMany(
            Articulo::class,
            'Lista_Articulos', //tabla pivote
            'fk_id_Ventas', //fk referenciando al modelo Venta
            'fk_id_articulo', //fk referenciando al modelo Articulo
            'id',// pk de Venta
            'id'// pk de Articulo
        ) -> withPivot('cantidad');
    }
}
