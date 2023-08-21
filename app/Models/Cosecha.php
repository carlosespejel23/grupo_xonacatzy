<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cosecha extends Model
{
    use HasFactory;
    protected $table = 'cosechas';
    protected $fillable = [
        'cultivo_id',
        'num_botes',
        'invernadero',
        'corte',
        'encargado',
        'fecha'
    ];
}
