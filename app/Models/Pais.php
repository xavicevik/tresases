<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
    protected $table = 'paises';
    protected $fillable =[
        'nombre',
        'zona',
        'descripcion',
        'moneda'
    ];

    public function departamentos()
    {
        return $this->hasMany(Departamento::class, 'idpais');
    }

    public function puntoventa()
    {
        return $this->hasMany(Puntoventa::class, 'idpais', 'id');
    }

    public function rifas()
    {
        return $this->hasMany(Rifa::class, 'idpais', 'id');
    }
}
