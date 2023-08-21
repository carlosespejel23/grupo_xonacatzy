<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gasto_Extra extends Model
{
    use HasFactory;
    protected $table = 'gastos_extras';
    protected $fillable = [
        'nombre',
        'monto',
        'fecha'
    ];
}
