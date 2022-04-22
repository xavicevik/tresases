<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleUser extends Model
{
    protected $fillable = [
        'idrol',
        'estado',
        'idtipos_documento',
        'num_documento',
        'direccion', 'indicativo',
        'idpais',
        'idciudad',
        'iddepartamento',
        'obervaciones',
        'telefono',
        'movil'
    ];

    public function pais()
    {
        return $this->belongsTo(Pais::class);
    }

    public function ciudad()
    {
        return $this->belongsTo(Ciudad::class);
    }

    public function departamento()
    {
        return $this->belongsTo(Ciudad::class);
    }

    public function tipodocumento()
    {
        return $this->belongsTo(TiposDocumento::class);
    }

    public function rol()
    {
        return $this->belongsTo(Rol::class);
    }
}
