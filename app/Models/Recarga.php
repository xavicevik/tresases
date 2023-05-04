<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recarga extends Model
{
    protected $table = 'recargas';
    protected $fillable = ['idusuario','valor','idvendedor', 'estado', 'metodopago'];

    public function user(){
        return $this->belongsTo(User::class, 'idusuario');
    }

    public function vendedor(){
        return $this->belongsTo(Vendedor::class, 'idvendedor');
    }
}
