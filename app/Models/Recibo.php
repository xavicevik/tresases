<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recibo extends Model
{
    protected $table = 'recibos';
    protected $fillable =[
        'nombre',
        'url',
        'idusuario',
        'iduserdestino',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'idusuario');
    }

    public function userdestino(){
        return $this->belongsTo(User::class, 'iduserdestino');
    }
}
