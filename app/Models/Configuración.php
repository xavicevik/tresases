<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Configuración extends Model
{
    protected $table = 'configuration';
    protected $fillable =[
        'nombre',
        'valornum',
        'valorstr',
        'detalle',
    ];
}
