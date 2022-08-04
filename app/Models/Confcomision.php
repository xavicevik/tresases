<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Confcomision extends Model
{
    protected $table = 'confcomisiones';
    protected $fillable =[
        'idmayorista',
        'iddistribuidor',
        'idvendedor',
        'comisionmayorista',
        'comisiondistribuidor',
        'comisionvendedor',
        'estado'
    ];

    public function salesman()
    {
        return $this->belongsTo(Empresa::class, 'idvendedor')->where('idtipoempresa', 3);
    }

    public function agente()
    {
        return $this->belongsTo(Vendedor::class, 'idvendedor');
    }

    public function distribuidor(){
        return $this->belongsTo(Empresa::class, 'iddistribuidor')->where('idtipoempresa', 2);
    }

    public function mayorista(){
        return $this->belongsTo(Empresa::class, 'idmayorista')->where('idtipoempresa', 1);
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
