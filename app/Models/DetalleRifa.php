<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleRifa extends Model
{
    protected $table = 'detalle_rifas';
    protected $fillable =[
        'idrifa',
        'cantidad',
        'reservados',
        'rango',
        'numeros',
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

    public function loteria(){
        return $this->belongsTo(Loteria::class, 'idloteria');
    }

    public function terminosycondiciones(){
        return $this->belongsTo(Terminosycondiciones::class, 'idterminos');
    }

    public function user(){
        return $this->belongsTo(User::class, 'idcreador');
    }

    public function detalleuser(){
        return $this->belongsTo(DetalleUser::class, 'idcreador');
    }
}
