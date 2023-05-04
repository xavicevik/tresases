<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DetalleConciliacion extends Model
{
    protected $table = 'detalleconciliaciones';
    protected $fillable =[
        'idvendedor',
        'idconciliacion',
        'idboleta',
        'idusuario',
        'estado'
    ];

    public function vendedor()
    {
        return $this->belongsTo(Vendedor::class, 'idvendedor');
    }

    public function conciliacion()
    {
        return $this->belongsTo(Conciliacion::class, 'idconciliacion');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'idusuario');
    }

    public function boleta()
    {
        return $this->belongsTo(Boleta::class, 'idboleta');
    }

}
