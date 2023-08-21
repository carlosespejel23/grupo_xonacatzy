<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cama_Cosecha extends Model
{
    use HasFactory;
    protected $table = 'camas_cosechas';
    protected $fillable = [
        'cosecha_id',
        'num_cama'
    ];
}
