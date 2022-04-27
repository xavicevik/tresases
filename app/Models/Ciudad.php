<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ciudad extends Model
{
    protected $table = 'ciudades';
    protected $fillable =[
        'idpais',
        'idlocal',
        'iddepartamento',
        'nombre',
        'descripcion',
    ];

    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }

    public function pais()
    {
        return $this->belongsTo(Pais::class);
    }
}
