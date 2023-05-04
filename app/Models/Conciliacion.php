<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Conciliacion extends Model
{
    protected $table = 'conciliaciones';
    protected $fillable =[
        'idvendedor',
        'valor',
        'idusuario',
        'estado',
        'cantidad'
    ];

    public function vendedor()
    {
        return $this->belongsTo(Vendedor::class, 'idvendedor');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'idusuario');
    }

}
