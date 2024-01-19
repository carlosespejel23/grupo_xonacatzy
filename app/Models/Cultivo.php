<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Cultivo extends Model
{
    use HasFactory;
    use Searchable;
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

    //Buscador de cultivos por busqueda simple (palabras clave)
    public function toSearchableArray()
    {
        return [
            'nombre' => $this->nombre,
            'nombre_tecnico' => $this->nombre_tecnico,
            'encargado' => $this->encargado,
            'fecha_ingreso' => $this->fecha_ingreso,
        ];
    }
}
