<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    protected $table = 'departamentos';
    protected $fillable =[
        'idpais',
        'nombre',
        'descripcion',
    ];

    public function pais()
    {
        return $this->belongsTo(Pais::class, 'idpais');
    }

    public function ciudades()
    {
        return $this->hasMany(Ciudad::class, 'iddepartamento');
    }
}
