<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pago extends Model
{
    protected $table = 'pagos';
    protected $fillable =[
        'idventa',
        'valortotal',
        'idcliente',
        'idvendedor',
        'saldo',
        'canal',
        'descripcion',
        'tipo',
        'soporte',
        'idtransaccion',
        'idpuntoventa',
        'idcaja'
    ];

    public function vendedor()
    {
        return $this->belongsTo(Vendedor::class, 'idvendedor');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'idcliente');
    }

    public function puntoventa()
    {
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
