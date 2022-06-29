<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rifa extends Model
{
    protected $table = 'rifas';
    protected $fillable =[
        'titulo',
        'resolucion',
        'estado',
        'nombre',
        'descripcion',
        'nombre_tecnico',
        'resumen',
        'url',
        'idloteria',
        'idpais',
        'iddepartamento',
        'idciudad',
        'cifras',
        'precio',
        'fechainicio',
        'fechafin',
        'promocional',
        'publicar',
        'fisica',
        'principal',
        'urlimagen1',
        'urlimagen2',
        'idterminos',
        'idcreador',
        'serieoculta',
        'serie',
        'idserie'
    ];

    public function scopeActive($query) {
        return $query->where('estado', '1');
    }
    public function promocionales() {
        return $this->hasMany(Promocional::class, 'idrifa');
    }
    public function pais(){
        return $this->belongsTo(Pais::class, 'idpais');
    }

    public function departamento(){
        return $this->belongsTo(Departamento::class, 'iddepartamento');
    }

    public function ciudad(){
        return $this->belongsTo(Ciudad::class, 'idciudad');
    }

    public function loteria(){
        return $this->belongsTo(Loteria::class, 'idloteria');
    }

    public function terminosycondiciones(){
        return $this->belongsTo(Terminosycondiciones::class, 'idterminos');
    }

    public function user(){
        return $this->belongsTo(User::class, 'idcreador');
    }

    public function tiposerie(){
        return $this->belongsTo(Serie::class, 'idserie');
    }
}
