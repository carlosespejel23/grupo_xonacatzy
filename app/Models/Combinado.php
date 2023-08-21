<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Combinado extends Model
{
    use HasFactory;
    protected $table = 'combinados';
    protected $fillable = [
        'cultivo_id',
        'num_bolsas',
        'gramos',
        'fecha'
    ];
}
