<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cama_Registro extends Model
{
    use HasFactory;
    protected $table = 'camas_registros';
    protected $fillable = [
        'registro_id',
        'num_cama'
    ];
}
