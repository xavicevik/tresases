<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NumeroReservado extends Model
{
    protected $table = 'numeros_reservados';
    protected $fillable =[
        'idrifa',
        'numero',
        'estado',
        'rangoinicial',
        'rangofinal',
        'idvendedor',
        'idcliente',
        'fecha',
    ];

    public function rifa(){
        return $this->belongsTo(Rifa::class, 'idrifa');
    }

    public function cliente(){
        return $this->belongsTo(Cliente::class, 'idcliente');
    }

    public function vendedor(){
        return $this->belongsTo(Vendedor::class, 'idvendedor');
    }
}
