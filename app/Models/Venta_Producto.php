<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta_Producto extends Model
{
    use HasFactory;
    protected $table = 'ventas_productos';
    protected $fillable = [
        'producto_id',
        'cantidad',
        'fecha',
    ];
}
