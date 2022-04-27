<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loteria extends Model
{
    protected $table = 'loterias';
    protected $fillable =[
        'nombre',
        'descripcion',
    ];

    public function rifa(){
        return $this->hasMany(Rifa::class, 'idrifa', 'id');
    }
}
