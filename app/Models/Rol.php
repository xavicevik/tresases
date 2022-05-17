<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Rol extends Model
{
    protected $table = 'roles';
    protected $fillable = ['nombre','descripcion','estado'];
    public $timestamps = false;

    public function scopeActive($query) {
        return $query->where('estado', '1');
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

}
