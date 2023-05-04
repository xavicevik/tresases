<?php

namespace App\Exports;

use App\Models\Boleta;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class BoletasExport implements FromCollection, WithHeadings, ShouldAutoSize
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
        //DB::connection()->enableQueryLog();
        $filtros = json_decode($this->request['filtros']);

        $boletas = Boleta::join('rifas', 'boletas.idrifa', '=', 'rifas.id')
                        ->leftJoin('vendedors as t1', 'boletas.idvendedor', '=', 't1.id')
                        ->leftJoin('clientes as t2', 'boletas.idcliente', '=', 't2.id')
                        ->leftJoin('estados', 'boletas.estado', '=', 'estados.id');
        if (!is_null($filtros)) {
            if(!is_null($filtros->rifa) && $filtros->rifa <> '' && $filtros->rifa <> 0) {
                $boletas = $boletas->where('rifas.id', $filtros->rifa);
            }

            if(!is_null($filtros->numero) && $filtros->numero <> '' && $filtros->numero <> 0) {
                $boletas = $boletas->where('boletas.numero', 'like', '%'.$filtros->numero.'%');
            }

            if(!is_null($filtros->promocional) && $filtros->promocional <> '' && $filtros->promocional <> 0) {
                $boletas = $boletas->where('boletas.promocional', 'like', '%'.$filtros->promocional.'%');
            }

            if(!is_null($filtros->estado) && $filtros->estado <> '') {
                $boletas = $boletas->where('boletas.estado', 'like', '%'.$filtros->estado.'%');
            }
            if(!is_null($filtros->vendedor) && $filtros->vendedor <> '' && $filtros->vendedor <> 0) {
                $boletas = $boletas->where('boletas.idvendedor', $filtros->vendedor);
            }
            if(!is_null($filtros->cliente) && $filtros->cliente <> '' && $filtros->cliente <> 0) {
                $boletas = $boletas->where('t2.nombre', 'like', '%'.$filtros->cliente.'%')
                                    ->orWhere('t2.apellido', 'like', '%'.$filtros->cliente.'%')
                                    ->orWhere('t2.documento', 'like', '%'.$filtros->cliente.'%');
            }
            //$queries = DB::getQueryLog();
        }
        if (Auth::user()->idrol == 7) {
            $boletas = $boletas->where('rifas.resumen', Auth::user()->idempresa);
        }

        return $boletas->select('rifas.titulo as rifa',
                                'boletas.numero as numero',
                                'boletas.promocional as promocional',
                                DB::raw('CONCAT(t1.nombre, " ", t1.apellido) AS vendedor'),
                                't2.documento as documento_cliente',
                                DB::raw('CONCAT(t2.nombre, " ", t2.apellido) AS cliente'),
                                'boletas.serie as serie',
                                'boletas.codigo as codigo',
                                 DB::raw('CASE
                                                    WHEN boletas.metodopago = 1 THEN "Efectivo"
                                                    WHEN boletas.metodopago = 2 THEN "Tarjeta C/D"
                                                    WHEN boletas.metodopago = 4 THEN "Bolsa"
                                                    ELSE " "
                                                END
                                  AS metodo_pago'),
                                'boletas.valor as valor_boleta',
                                'boletas.pago as valor_pagado',
                                'boletas.saldo as valor_saldo',
                                DB::raw('getcomisionboleta(boletas.id) as comision'),
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
            'Documento_Cliente',
            'Cliente',
            'Serie',
            'Código',
            'Metodo_pago',
            'Valor_boleta',
            'Valor_pagado',
            'Valor_saldo',
            'Comision',
            'Estado',
            'Fecha_creacion',
            'Fecha_ultima_actualizacion'
        ];
    }
}
