<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Caja extends Model
{
    protected $table = 'cajas';
    protected $fillable =[
        'idvendedor',
        'idpuntoventa',
        'montoapertura',
        'montocierre',
        'fechaapertura',
        'fechacierre',
        'estado'
    ];

    public function vendedor()
    {
        return $this->belongsTo(User::class, 'idvendedor');
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
