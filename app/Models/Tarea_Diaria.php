<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarea_Diaria extends Model
{
    use HasFactory;
    protected $table = 'tareas_diarias';
    protected $fillable = [
        'nombre',
        'fecha',
    ];
}
