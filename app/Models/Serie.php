<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Serie extends Model
{
    protected $table = 'series';
    protected $fillable = ['nombre','cifras','detalle', 'estado'];
    public $timestamps = false;

    public function rifas()
    {
        return $this->hasMany(Serie::class);
    }
}
