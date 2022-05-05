<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table = 'ventas';
    protected $fillable =[
        'idrifa',
        'valorventa',
        'impuesto',
        'comision',
        'valortotal',
        'cantidad',
        'idvendedor',
        'idcliente',
        'idpuntoventa',
        'fechaventa',
        'estado',
        'transaccion',
    ];

    public function scopeActive($query) {
        return $query->where('estado', '1');
    }

    public function puntoventa(){
        return $this->belongsTo(Puntoventa::class, 'idpuntoventa');
    }

    public function rifa(){
        return $this->belongsTo(Rifa::class, 'idrifa');
    }

    public function cliente(){
        return $this->belongsTo(User::class, 'idcliente');
    }

    public function vendedor(){
        return $this->belongsTo(User::class, 'idvendedor');
    }
}
