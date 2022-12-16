<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Boleta extends Model implements Auditable
{
    use AuditableTrait;
    
    protected $table = 'boletas';
    protected $fillable =[
        'idrifa',
        'numero',
        'promocional',
        'idvendedor',
        'idcliente',
        'serie',
        'precio',
        'pago',
        'saldo',
        'codigo',
        'estado',
        'estado_ant'
    ];


    public function rifa()
    {
        return $this->belongsTo(Rifa::class, 'idrifa');
    }
    public function scopeUseIndex($query, string $index)
    {
        $table = $this->getTable();

        return $query->from(DB::raw("`$table` USE INDEX(`$index`)"));
    }
    public function scopeForceIndex($query, string $index)
    {
        $table = $this->getTable();

        return $query->from(DB::raw("`$table` FORCE INDEX(`$index`)"));
    }
    public function cliente(){
        return $this->belongsTo(Cliente::class, 'idcliente');
    }
    public function vendedor(){
        return $this->belongsTo(Vendedor::class, 'idvendedor');
    }
    public function estado(){
        return $this->belongsTo(Estado::class, 'estado');
    }
}
