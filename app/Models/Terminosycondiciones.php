<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Terminosycondiciones extends Model
{
    protected $table = 'terminos_condiciones';
    protected $fillable =[
        'nombre',
        'descripcion',
        'terminosycondiciones',
        'url',
        'estado'
    ];

    public function rifas()
    {
        return $this->hasMany(Rifa::class);
    }
}


