<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cultivo extends Model
{
    use HasFactory;
    protected $table = 'cultivos';
    protected $fillable = [
        'provedor_id',
        'nombre',
        'nombre_tecnico',
        'cantidad',
        'fecha_ingreso'
    ];

    //Relacion a tabla provedores
    public function provedor()
    {
        return $this->belongsTo(Provedor::class, 'provedor_id'); // 'provedor_id' debe ser el nombre del campo de clave foránea en la tabla 'cultivos'.
    }
}
