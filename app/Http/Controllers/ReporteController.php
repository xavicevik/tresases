<?php

namespace App\Http\Controllers;

use App\Models\Boleta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ReporteController extends Controller
{
    const canPorPagina = 20;

    public function index(Request $request)
    {
        //DB::connection()->enableQueryLog();
        $filtros = json_decode($request->filtros);

        if ($request->has('sortBy') && $request->sortBy <> ''){
            $sortBy = $request->sortBy;
        } else {
            $sortBy = 'boletas.id';
        }

        if ($request->has('sortOrder') && $request->sortOrder <> ''){
            $sortOrder = $request->sortOrder;
        } else {
            $sortOrder = 'desc';
        }

        if (is_null($filtros)){
            $boletas = Boleta::orderBy($sortBy, $sortOrder)
                ->with('rifa')
                ->with('vendedor')
                ->with('cliente')
                ->paginate(self::canPorPagina);
        } else {
            $boletas = Boleta::orderBy($sortBy, $sortOrder)
                ->with('rifa')
                ->with('vendedor')
                ->with('cliente');

            if(!is_null($filtros->rifa) && $filtros->rifa <> '' && $filtros->rifa <> 0) {
                $boletas = $boletas->where('boletas.idrifa', $filtros->rifa);
            }

            if(!is_null($filtros->vendedor) && $filtros->vendedor <> '' && $filtros->vendedor <> 0) {
                $boletas = $boletas->where('boletas.idvendedor', $filtros->vendedor);
            }

            if(!is_null($filtros->numero) && $filtros->numero <> '') {
                $boletas = $boletas->where('numero', 'like', '%'.$filtros->numero.'%');
            }

            if(!is_null($filtros->promocional) && $filtros->promocional <> '') {
                $boletas = $boletas->where('promocional', 'like', '%'.$filtros->promocional.'%');
            }

            if(!is_null($filtros->estado) && $filtros->estado <> '') {
                $boletas = $boletas->where('boletas.estado', 'like', '%'.$filtros->estado.'%');
            }

            if(!is_null($filtros->cliente) && $filtros->cliente <> '') {
                $boletas = $boletas->join('clientes as t1', 'boletas.idcliente', '=', 't1.id')
                    ->where('t1.nombre', 'like', '%'.$filtros->cliente.'%')
                    ->orWhere('t1.apellido', 'like', '%'.$filtros->cliente.'%')
                    ->orWhere('t1.documento', 'like', '%'.$filtros->cliente.'%');
            }

            $boletas = $boletas->select('boletas.*')->paginate(self::canPorPagina);
        }
        //$queries = DB::getQueryLog();

        if ($request->has('ispage') && $request->ispage){
            return ['datos' => $boletas];
        } else {
            return Inertia::render('Reportes/Index', ['datos' => $boletas, 'estado' => $request->estado]);
        }
    }

    public function vendedor(Request $request)
    {
        DB::connection()->enableQueryLog();
        $filtros = json_decode($request->filtros);

        if ($request->has('sortBy') && $request->sortBy <> ''){
            $sortBy = $request->sortBy;
        } else {
            $sortBy = 'boletas.id';
        }

        if ($request->has('sortOrder') && $request->sortOrder <> ''){
            $sortOrder = $request->sortOrder;
        } else {
            $sortOrder = 'desc';
        }

        if (is_null($filtros)){
            $boletas = Boleta::where('idrifa', $filtros->rifa)
                ->join('vendedors', 'boletas.idvendedor', '=', 'vendedors.id')
                ->join('estados', 'boletas.estado', '=', 'estados.id');
        } else {
            $boletas = Boleta::where('idrifa', $filtros->rifa)
                ->join('vendedors', 'boletas.idvendedor', '=', 'vendedors.id')
                ->join('estados', 'boletas.estado', '=', 'estados.id');

            if(!is_null($filtros->fechainicio) && $filtros->fechainicio <> '') {
                $boletas = $boletas->where('boletas.updated_at', '>=', $filtros->fechainicio);
            }
            if(!is_null($filtros->fechafin) && $filtros->fechafin <> '') {
                $boletas = $boletas->where('boletas.updated_at', '<=', $filtros->fechafin);
            }

            if(!is_null($filtros->vendedor) && $filtros->vendedor <> '' && $filtros->vendedor <> 0) {
                $boletas = $boletas->where('boletas.idvendedor', $filtros->vendedor);
            }
            if(!is_null($filtros->estado) && $filtros->estado <> '-') {
                $boletas = $boletas->where('boletas.estado', $filtros->estado);
            }
        }
        $boletas = $boletas->select(DB::raw('vendedors.id, vendedors.nombre, vendedors.apellido, count(1) as cantidad, sum(pago) as pagado, sum(saldo) as saldo, getcomision(vendedors.id, -1) comision'))
                            //->groupBy('boletas.idvendedor');
                            ->groupBy('vendedors.id', 'vendedors.nombre', 'vendedors.apellido');

        $resultado = DB::query()->from($boletas, 'a')->paginate(self::canPorPagina);

        $queries = DB::getQueryLog();

        if ($request->has('ispage') && $request->ispage){
            return ['datos' => $resultado];
        } else {
            return Inertia::render('Reportes/Index', ['datos' => $resultado, 'estado' => $request->estado]);
        }
    }

    public function getDetalleVendedor(Request $request)
    {
        DB::connection()->enableQueryLog();
        $filtros = json_decode($request->filtros);

        if ($request->has('sortBy') && $request->sortBy <> ''){
            $sortBy = $request->sortBy;
        } else {
            $sortBy = 'boletas.id';
        }

        if ($request->has('sortOrder') && $request->sortOrder <> ''){
            $sortOrder = $request->sortOrder;
        } else {
            $sortOrder = 'desc';
        }

        if (is_null($filtros)){
            $boletas = Boleta::where('idrifa', $filtros->rifa)
                ->where('idvendedor', $request->idvendedor)
                ->join('vendedors', 'boletas.idvendedor', '=', 'vendedors.id')
                ->join('estados', 'boletas.estado', '=', 'estados.id');
        } else {
            $boletas = Boleta::where('idrifa', $filtros->rifa)
                ->where('idvendedor', $request->idvendedor)
                ->join('vendedors', 'boletas.idvendedor', '=', 'vendedors.id')
                ->join('estados', 'boletas.estado', '=', 'estados.id');

            if(!is_null($filtros->fechainicio) && $filtros->fechainicio <> '') {
                $boletas = $boletas->where('boletas.updated_at', '>=', $filtros->fechainicio);
            }
            if(!is_null($filtros->fechafin) && $filtros->fechafin <> '') {
                $boletas = $boletas->where('boletas.updated_at', '<=', $filtros->fechafin);
            }

            if(!is_null($filtros->vendedor) && $filtros->vendedor <> '' && $filtros->vendedor <> 0) {
                $boletas = $boletas->where('boletas.idvendedor', $filtros->vendedor);
            }
            if(!is_null($filtros->estado) && $filtros->estado <> '-') {
                $boletas = $boletas->where('boletas.estado', $filtros->estado);
            }
        }
        $boletas = $boletas->select(DB::raw('vendedors.id, vendedors.nombre, vendedors.apellido, count(1) as cantidad, sum(pago) as pagado, sum(saldo) as saldo, estados.nombre as estado, getcomision(vendedors.id, boletas.estado) comision'))
                            //->groupBy('boletas.idvendedor', 'boletas.estado');
                            ->groupBy('vendedors.id', 'vendedors.nombre', 'vendedors.apellido', 'boletas.estado', 'estados.nombre');

        $queries = DB::getQueryLog();

        $resultado = DB::query()->from($boletas, 'a')->paginate(self::canPorPagina);


        return ['data' => $resultado];
    }
}
