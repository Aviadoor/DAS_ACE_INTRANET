<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lista_Articulos extends Model
{
    use HasFactory;

    protected $table = 'Lista_Articulos';
    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'fk_id_articulo',
        'fk_id_Ventas',
        'cantidad'
    ];
}
