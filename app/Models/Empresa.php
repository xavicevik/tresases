<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $table = 'empresas';
    protected $fillable =[
        'documento',
        'idpadre',
        'idtipoempresa',
        'digit',
        'estado',
        'idtipos_documento',
        'idpais',
        'idciudad',
        'iddepartamento',
        'observaciones',
        'isnatural',
        'telefono',
        'direccion',
        'camaracomercio',
        'rut',
        'url',
    ];

    public function scopeActive($query) {
        return $query->where('estado', '1');
    }

    public function mayoristas() {
        return $this->hasMany(User::class, 'idempresa')->where('idrol', '=', '4');;
    }

    public function distribuidores() {
        return $this->hasMany(User::class, 'idempresa')->where('idrol', '=', '3');
    }

    public function vendedores() {
        return $this->hasMany(Vendedor::class, 'idempresa')->where('idrol', '=', '5');
    }

    public function padre(){
        return $this->belongsTo(Empresa::class, 'idpadre');
    }

    public function hijos(){
        return $this->hasMany(Empresa::class, 'idpadre');
    }

    public function tipoempresa(){
        return $this->belongsTo(TipoEmpresa::class, 'idtipoempresa');
    }

    public function tipodocumento(){
        return $this->belongsTo(TiposDocumento::class, 'idtipos_documento');
    }

    public function departamento(){
        return $this->belongsTo(Departamento::class, 'iddepartamento');
    }

    public function ciudad(){
        return $this->belongsTo(Ciudad::class, 'idciudad');
    }

    public function pais(){
        return $this->belongsTo(Pais::class, 'idpais');
    }

    public function puntosventa() {
        return $this->hasMany(Puntoventa::class, 'idempresa');
    }
}
