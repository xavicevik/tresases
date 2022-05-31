<?php

namespace App\Http\Controllers;

use App\Models\Caja;
use App\Models\Historialcaja;
use App\Models\Pago;
use App\Models\Transaccion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Laravel\Jetstream\Jetstream;

class Pagocontroller extends Controller
{
    const canPorPagina = 10;
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index(Request $request)
    {
        $filtros = json_decode($request->filtros);

        if ($request->has('sortBy') && $request->sortBy <> ''){
            $sortBy = $request->sortBy;
        } else {
            $sortBy = 'pagos.id';
        }

        if ($request->has('sortOrder') && $request->sortOrder <> ''){
            $sortOrder = $request->sortOrder;
        } else {
            $sortOrder = 'desc';
        }

        if (is_null($filtros)){
            $pagos = Pago::orderBy($sortBy, $sortOrder)
                ->with('vendedor')
                ->with('cliente')
                ->with('puntoventa')
                ->paginate(self::canPorPagina);
        } else {

            $pagos = Pago::orderBy($sortBy, $sortOrder)
                ->with('vendedor')
                ->with('cliente')
                ->with('puntoventa');

            if(!is_null($filtros->fechainicio)) {
                $pagos = $pagos->where('pagos.created_at', '>=', $filtros->fechainicio);
            }
            if(!is_null($filtros->fechafin)) {
                $pagos = $pagos->where('pagos.created_at', '<=', $filtros->fechafin);
            }
            if(!is_null($filtros->cliente)) {
                $pagos = $pagos->join('users as t1', 'pagos.idcliente', '=', 't1.id')
                    ->where('t1.username', 'like', '%'.$filtros->cliente.'%');
            }
            if(!is_null($filtros->vendedor)) {
                $pagos = $pagos->join('users as t2', 'pagos.idvendedor', '=', 't2.id')
                    ->where('t2.username', 'like', '%'.$filtros->vendedor.'%');
            }
            if(!is_null($filtros->venta)) {
                $pagos = $pagos->where('idventa', 'like', '%'.$filtros->venta.'%');
            }
            if(!is_null($filtros->puntoventa)) {
                $pagos = $pagos->join('puntos_ventas', 'pagos.idpuntoventa', '=', 'puntos_ventas.id')
                    ->where('puntos_ventas.nombre', 'like', '%'.$filtros->puntoventa.'%');
            }
            if(!is_null($filtros->canal)) {
                $pagos = $pagos->where('canal', 'like', '%'.$filtros->canal.'%');
            }
            if(!is_null($filtros->tipo)) {
                $pagos = $pagos->where('tipo', 'like', '%'.$filtros->tipo.'%');
            }

            if(!is_null($filtros->soporte)) {
                $pagos = $pagos->where('soporte', 'like', '%'.$filtros->soporte.'%');
            }

            $pagos = $pagos->select('pagos.*')->paginate(self::canPorPagina);
        }

        if ($request->has('ispage') && $request->ispage){
            return ['datos' => $pagos];
        } else {
            return Inertia::render('Pagos/Index', ['datos' => $pagos, 'estado' => $request->estado]);
        }
    }

    public function historial(Request $request)
    {
        $buscar = $request->buscar;

        if ($request->has('sortBy') && $request->sortBy <> ''){
            $sortBy = $request->sortBy;
        } else {
            $sortBy = 'id';
        }

        if ($request->has('sortOrder') && $request->sortOrder <> ''){
            $sortOrder = $request->sortOrder;
        } else {
            $sortOrder = 'desc';
        }

        if ($buscar == ''){
            $cajas = Historialcaja::orderBy($sortBy, $sortOrder)
                ->with('caja')
                ->with('vendedor')
                ->with('puntoventa')
                ->paginate(self::canPorPagina);
        } else {
            $cajas = Historialcaja::orderBy($sortBy, $sortOrder)
                ->with('caja')
                ->with('vendedor')
                ->with('puntoventa')
                ->paginate(self::canPorPagina);
        }

        if ($request->has('ispage') && $request->ispage){
            return ['cajas' => $cajas];
        } else {
            return Inertia::render('Cajas/Historial', ['cajas' => $cajas, 'estado' => $request->estado]);
        }
    }
}
