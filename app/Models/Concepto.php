<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Concepto extends Model
{
    protected $table = 'conceptos';
    protected $fillable =[
        'nombre',
        'descripcion',
        'estado',
    ];
}
