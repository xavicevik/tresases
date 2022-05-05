<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promocional extends Model
{
    protected $table = 'promocionales';
    protected $fillable =[
        'idrifa',
        'idloteria',
        'fecha',
        'cifras',
        'premio',
        'descripcion',
        'estado'
    ];

    public function rifa(){
        return $this->belongsTo(Rifa::class, 'idrifa');
    }

    public function loteria(){
        return $this->belongsTo(Loteria::class, 'idloteria');
    }
}
