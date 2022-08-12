<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Historialcaja extends Model
{
    protected $table = 'historialcajas';
    protected $fillable =[
        'idcaja',
        'idvendedor',
        'idpuntoventa',
        'montoapertura',
        'montocierre',
        'recaudoefectivo',
        'fechaapertura',
        'fechacierre',
        'sobrante',
        'faltante',
        'estado'
    ];

    public function caja()
    {
        return $this->belongsTo(Caja::class, 'idcaja');
    }

    public function vendedor()
    {
        return $this->belongsTo(Userview::class, 'idvendedor');
    }

    public function puntoventa(){
        return $this->belongsTo(Puntoventa::class, 'idpuntoventa');
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
