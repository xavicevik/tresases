<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Boleta extends Model
{
    protected $table = 'boletas';
    protected $fillable =[
        'idrifa',
        'numero',
        'serie',
        'codigo',
        'estado',
    ];


    public function rifa()
    {
        return $this->belongsTo(Rifa::class, 'idrifa');
    }

    public function scopeUseIndex(Builder $query, string $index): Builder
    {
        $table = $this->getTable();

        return $query->from(DB::raw("`$table` USE INDEX(`$index`)"));
    }

    public function scopeForceIndex($query, string $index)
    {
        $table = $this->getTable();

        return $query->from(DB::raw("`$table` FORCE INDEX(`$index`)"));
    }

}
