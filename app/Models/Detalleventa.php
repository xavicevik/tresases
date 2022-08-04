<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detalleventa extends Model
{
    protected $table = 'detalle_ventas';
    protected $fillable =[
        'idventa',
        'idboleta',
        'idrifa',
        'valor',
        'impuesto',
        'comision',
        'valortotal',
        'numero',
        'serie',
        'cantidad',
        'estado'
    ];

    public function scopeActive($query) {
        return $query->where('estado', '1');
    }

    public function venta(){
        return $this->belongsTo(Venta::class, 'idventa');
    }

    public function cliente(){
        return $this->belongsTo(Cliente::class, 'idcliente');
    }

    public function boleta(){
        return $this->belongsTo(Boleta::class, 'idboleta');
    }

    public function rifa(){
        return $this->belongsTo(Rifa::class, 'idrifa');
    }

}
