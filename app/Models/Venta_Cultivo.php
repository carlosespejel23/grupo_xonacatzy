<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta_Cultivo extends Model
{
    use HasFactory;
    protected $table = 'ventas_cultivos';
    protected $fillable = [
        'mercado_id',
        'cantidad',
        'fecha',
    ];
}
