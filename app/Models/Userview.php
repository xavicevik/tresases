<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Userview extends Model
{
    protected $table = 'usersviews';
    protected $fillable =[
        'id',
        'full_name',
        'documento',
        'correo',
        'username',
        'idrol',
        'estado',
        'idtipos_documento',
        'movil',
    ];
}
