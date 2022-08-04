<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table = 'ventas';
    protected $fillable =[
        'idrifa',
        'valorventa',
        'impuesto',
        'comision',
        'valortotal',
        'cantidad',
        'idvendedor',
        'idcliente',
        'idpuntoventa',
        'fechaventa',
        'comprobante',
        'urlrecibo',
        'estado',
        'transaccion',
    ];

    public function scopeActive($query) {
        return $query->where('estado', '1');
    }

    public function scopeUseIndex(Builder $query, string $index): Builder
    {
        $table = $this->getTable();

        return $this->tableIndexExists($index)
            ? $query->from(DB::raw("`$table` USE INDEX(`$index`)"))
            : $query;
    }

    public function scopeForceIndex(Builder $query, string $index): Builder
    {
        $table = $this->getTable();

        return $this->tableIndexExists($index)
            ? $query->from(DB::raw("`$table` FORCE INDEX(`$index`)"))
            : $query;
    }

    private function tableIndexExists(string $index): boolean
    {
        $table = $this->getTable();
        $index = strtolower($index);
        $indices = Schema::getConnection()
            ->getDoctrineSchemaManager()
            ->listTableIndexes($table);

        return array_key_exists($index, $indices);
    }

    public function puntoventa(){
        return $this->belongsTo(Puntoventa::class, 'idpuntoventa');
    }
    public function cliente(){
        return $this->belongsTo(Cliente::class, 'idcliente');
    }
    public function vendedor(){
        return $this->belongsTo(Vendedor::class, 'idvendedor');
    }
    public function detalles() {
        return $this->hasMany(Detalleventa::class, 'idventa');
    }


}
