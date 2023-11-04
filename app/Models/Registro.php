<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registro extends Model
{
    use HasFactory;
    protected $table = 'registros';
    protected $fillable = [
        'provedor_id',
        'cultivo_id',
        'encargado1',
        'fecha_salida',
        'cantidad',
        'invernadero',
        'encargado2',
        'responsable'
    ];

    //Relacion a tabla provedores
    public function provedor()
    {
        return $this->belongsTo(Provedor::class, 'provedor_id'); // 'provedor_id' debe ser el nombre del campo de clave foránea en la tabla 'cultivos'.
    }
}
