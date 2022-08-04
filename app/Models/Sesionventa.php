<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sesionventa extends Model
{
    protected $table = 'sesionventas';
    protected $fillable = ['idusuario','idrifa','idvendedor', 'idpuntoventa', 'estado'];

    public function user(){
        return $this->belongsTo(User::class, 'idusuario');
    }

    public function rifa(){
        return $this->belongsTo(Rifa::class, 'idrifa');
    }

    public function vendedor(){
        return $this->belongsTo(Vendedor::class, 'idvendedor');
    }

    public function puntoventa(){
        return $this->belongsTo(Puntoventa::class, 'idpuntoventa');
    }
}
