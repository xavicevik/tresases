<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comision extends Model
{
    protected $table = 'comisiones';
    protected $fillable =[
        'idvena',
        'idconfiguracion',
        'valorventa',
        'comisionmayorista',
        'comisiondistribuidor',
        'comisionvendedor',
        'estado'
    ];

    public function venta(){
        return $this->belongsTo(Venta::class, 'idvena');
    }

    public function configuracion(){
        return $this->belongsTo(Confcomision::class, 'idconfiguracion');
    }
}
