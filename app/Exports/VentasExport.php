<?php

namespace App\Exports;

use App\Models\Boleta;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class VentasExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $filtros = json_decode($this->request['filtros']);

        $boletas = Boleta::join('rifas', 'boletas.idrifa', '=', 'rifas.id')
            ->join('users as t1', 'boletas.idvendedor', '=', 't1.id')
            ->join('users as t2', 'boletas.idcliente', '=', 't2.id')
            ->join('estados', 'boletas.estado', '=', 'estados.id');

        if (!is_null($filtros)) {
            if(!is_null($filtros->rifa) && $filtros->rifa <> '') {
                $boletas = $boletas->where('rifas.titulo', 'like', '%'.$filtros->rifa.'%');
            }

            if(!is_null($filtros->numero) && $filtros->numero <> '') {
                $boletas = $boletas->where('boletas.numero', 'like', '%'.$filtros->numero.'%');
            }

            if(!is_null($filtros->promocional) && $filtros->promocional <> '') {
                $boletas = $boletas->where('boletas.promocional', 'like', '%'.$filtros->promocional.'%');
            }

            if(!is_null($filtros->estado) && $filtros->estado <> '') {
                $boletas = $boletas->where('boletas.estado', 'like', '%'.$filtros->estado.'%');
            }
            if(!is_null($filtros->cliente) && $filtros->cliente <> '') {
                $boletas = $boletas->where('t1.nombre', 'like', '%'.$filtros->cliente.'%')
                    ->orWhere('t1.apellido', 'like', '%'.$filtros->cliente.'%');
            }
            if(!is_null($filtros->cliente) && $filtros->cliente <> '') {
                $boletas = $boletas->where('t2.nombre', 'like', '%'.$filtros->cliente.'%')
                    ->orWhere('t2.apellido', 'like', '%'.$filtros->cliente.'%');
            }
        }
        return $boletas->select('rifas.titulo as rifa',
            'boletas.numero as numero',
            'boletas.promocional as promocional',
            DB::raw('CONCAT(t1.nombre, " ", t1.apellido) AS vendedor'),
            DB::raw('CONCAT(t2.nombre, " ", t2.apellido) AS cliente'),
            'boletas.serie as serie',
            'boletas.codigo as codigo',
            'boletas.valor as valor_boleta',
            'boletas.pago as valor_pagado',
            'boletas.saldo as valor_saldo',
            'estados.nombre as estado',
            'boletas.created_at as fecha_creacion',
            'boletas.updated_at as fecha_ultima_modificacion')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Rifa',
            'número',
            'Promocional',
            'Vendedor',
            'Cliente',
            'Serie',
            'Código',
            'Valor_boleta',
            'Valor_pagado',
            'Valor_saldo',
            'Estado',
            'Fecha_creacion',
            'Fecha_ultima_actualizacion'
        ];
    }
}
