<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empaque extends Model
{
    use HasFactory;
    protected $table = 'empaques';
    protected $fillable = [
        'cultivo_id',
        'num_bolsas',
        'gramos',
        'encargado',
        'temp_inicial',
        'temp_final',
        'H2O',
        'fecha'
    ];
}
