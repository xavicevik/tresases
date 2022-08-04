<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detallesesion extends Model
{
    protected $table = 'detallesesion';
    protected $fillable = ['idsesionventa','idboleta', 'valor', 'idcliente'];

    public function sesion(){
        return $this->belongsTo(Sesionventa::class, 'idsesionventa ');
    }

    public function boleta(){
        return $this->belongsTo(Boleta::class, 'idboleta');
    }

    public function cliente(){
        return $this->belongsTo(Cliente::class, 'idcliente');
    }
}
