<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Puntoventa extends Model
{
    protected $table = 'puntos_ventas';
    protected $fillable =[
        'nombre',
        'direccion',
        'latitud',
        'altitud',
        'codigo',
        'estado',
        'descripcion',
        'idpais',
        'iddepartamento',
        'idciudad',
        'url'
    ];

    public function pais(){
        return $this->belongsTo(Pais::class, 'idpais');
    }

    public function departamento(){
        return $this->belongsTo(Departamento::class, 'iddepartamento');
    }

    public function ciudad(){
        return $this->belongsTo(Ciudad::class, 'idciudad');
    }

    public function empresa(){
        return $this->belongsTo(Empresa::class, 'idempresa');
    }
}
