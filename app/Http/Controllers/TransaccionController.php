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

class TransaccionController extends Controller
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
            $sortBy = 'transacciones.id';
        }

        if ($request->has('sortOrder') && $request->sortOrder <> ''){
            $sortOrder = $request->sortOrder;
        } else {
            $sortOrder = 'desc';
        }

        if (is_null($filtros)){
            $transacciones = Transaccion::orderBy($sortBy, $sortOrder)
                ->with('concepto')
                ->paginate(self::canPorPagina);
        } else {

            $transacciones = Transaccion::orderBy($sortBy, $sortOrder)
                                          ->with('concepto');

            if(!is_null($filtros->fechainicio)) {
                $transacciones = $transacciones->where('transacciones.created_at', '>=', $filtros->fechainicio);
            }
            if(!is_null($filtros->fechafin)) {
                $transacciones = $transacciones->where('transacciones.created_at', '<=', $filtros->fechafin);
            }
            if(!is_null($filtros->origen)) {
                $transacciones = $transacciones->join('users', 'transacciones.idusuarioori', '=', 'users.id')
                    ->where('users.username', 'like', '%'.$filtros->origen.'%')
                    ->select('transacciones.*');
            }

            if(!is_null($filtros->signo)) {
                $transacciones = $transacciones->where('signo', 'like', '%'.$filtros->signo.'%');
            }
            if(!is_null($filtros->concepto)) {
                $transacciones = $transacciones->join('conceptos', 'transacciones.idconcepto', '=', 'conceptos.id')
                                               ->where('conceptos.nombre', 'like', '%'.$filtros->concepto.'%')
                                               ->select('transacciones.*');
            }
            if(!is_null($filtros->soporte)) {
                $transacciones = $transacciones->where('soporte', 'like', '%'.$filtros->soporte.'%');
            }

            $transacciones = $transacciones->paginate(self::canPorPagina);
        }

        if ($request->has('ispage') && $request->ispage){
            return ['datos' => $transacciones];
        } else {
            return Inertia::render('Transacciones/Index', ['datos' => $transacciones, 'estado' => $request->estado]);
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
