<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TiposDocumento extends Model
{
    protected $table = 'tipos_documentos';
    protected $fillable = ['nombre','nombre_corto','estado'];
    public $timestamps = false;

    public function users()
    {
        return $this->hasMany('App\Models\User');
    }
}
