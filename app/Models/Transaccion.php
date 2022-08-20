<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Transaccion extends Model
{
    protected $table = 'transacciones';
    protected $fillable =[
        'idusuarioori',
        'idusuariodest',
        'idconcepto',
        'origen',
        'destino',
        'signo',
        'valor',
        'impuesto',
        'descripcion',
        'soporte',
        'mes',
        'ano',
    ];

    public function concepto()
    {
        return $this->belongsTo(Concepto::class, 'idconcepto');
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
