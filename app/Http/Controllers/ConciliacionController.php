<?php

namespace App\Http\Controllers;

use App\Models\Boleta;
use App\Models\Caja;
use App\Models\Conciliacion;
use App\Models\DetalleConciliacion;
use App\Models\Detalleventa;
use App\Models\Historialcaja;
use App\Models\Pago;
use App\Models\Transaccion;
use App\Models\User;
use App\Models\Vendedor;
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

class ConciliacionController extends Controller
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
            $sortBy = 'conciliaciones.id';
        }

        if ($request->has('sortOrder') && $request->sortOrder <> ''){
            $sortOrder = $request->sortOrder;
        } else {
            $sortOrder = 'desc';
        }

        if (is_null($filtros)){
            $conciliaciones = Conciliacion::orderBy($sortBy, $sortOrder)
                ->with('vendedor')
                ->with('usuario');
        } else {
            $conciliaciones = Conciliacion::orderBy($sortBy, $sortOrder)
                ->with('vendedor')
                ->with('usuario');

            if(!is_null($filtros->fechainicio)) {
                $conciliaciones = $conciliaciones->where('conciliaciones.created_at', '>=', $filtros->fechainicio);
            }
            if(!is_null($filtros->fechafin)) {
                $conciliaciones = $conciliaciones->where('conciliaciones.created_at', '<=', $filtros->fechafin);
            }

            if(!is_null($filtros->idusuario && $filtros->idusuario <> '' && $filtros->idusuario <> 0)) {
                $conciliaciones = $conciliaciones->where('idusuario', $filtros->idusuario);
            }

            if(!is_null($filtros->idvendedor && $filtros->idvendedor <> '' && $filtros->idvendedor <> 0)) {
                $conciliaciones = $conciliaciones->where('idvendedor', $filtros->idvendedor);
            }

        }
        $vendedores = Vendedor::where('estado', 1);
        $usuarios = User::where('estado', 1);

        if (Auth::user()->idrol == 7) {
            $conciliaciones = $conciliaciones->join('vendedors', 'conciliaciones.idvendedor', '=', 'vendedors.id')
                                                ->where('vendedors.idempresa', '=', Auth::user()->idempresa);
            $vendedores = $vendedores->where('idempresa', Auth::user()->idempresa);
            $usuarios = $usuarios->where('idempresa', Auth::user()->idempresa);
        }

        $vendedores = $vendedores->get();
        $usuarios = $usuarios->get();

        $conciliaciones = $conciliaciones->paginate(self::canPorPagina);
        if ($request->has('ispage') && $request->ispage){
            return ['datos' => $conciliaciones];
        } else {
            return Inertia::render('Conciliaciones/Index', ['datos' => $conciliaciones, 'vendedores' => $vendedores, 'usuarios' => $usuarios, 'estado' => $request->estado]);
        }
    }

    public function getBoletasbyVendedor(Request $request) {

        $detalles = Boleta::where('idvendedor', $request->idvendedor)
                           ->with('rifa')
                           ->where('conciliado', 0);

        if ($request->numero > 0) {
            $detalles = $detalles->where('numero', $request->numero);
        }
        $detalles = $detalles->get();

        return ['detalles' => $detalles];

    }

    public function getDetalleConciliacion(Request $request) {
        $detalles = DetalleConciliacion::where('idconciliacion', $request->idconciliacion)
            ->with('vendedor')
            ->with('boleta')
            ->with('usuario')
            ->get();

        return ['detalles' => $detalles];

    }

    public function store(Request $request) {
        try {
            // Begin a transaction
            DB::beginTransaction();
            $coniliacion = new Conciliacion();
            $cant = 0;
            $valor = 0;
            $neto = 0;
            $coniliacion->idvendedor = $request->idvendedor;
            $coniliacion->idusuario = Auth::id();
            $coniliacion->estado = 1;
            $coniliacion->valor = $valor;
            $coniliacion->neto = $neto;
            $coniliacion->cantidad = $cant;
            $coniliacion->save();

            $caja = Caja::where('tipo', 2)
                ->join('puntos_ventas', 'puntos_ventas.id', 'cajas.idpuntoventa')
                ->join('vendedors', 'puntos_ventas.idempresa', 'vendedors.idempresa')
                ->where('vendedors.id', $request->idvendedor)
                ->select('cajas.*')
                ->first();

            foreach ($request->all() as $key => $value) {
                if ($key != 'idvendedor') {
                    $boleta = Boleta::where('id', $key)->first();
                    $boleta->conciliado = true;
                    $boleta->save();

                    $venta = Detalleventa::where('idboleta', $boleta->id)
                                          ->where('estado', 3)
                                          ->orderBy('updated_at', 'desc')
                                          ->first();

                    $valor += $venta->valor;
                    $neto  += ($venta->valor - $venta->comision);
                    $cant++;

                    $detalle = new DetalleConciliacion();
                    $detalle->idconciliacion = $coniliacion->id;
                    $detalle->idboleta = $boleta->id;
                    $detalle->idusuario = Auth::id();
                    $detalle->idvendedor = $request->idvendedor;
                    $detalle->valor = $venta->valor;
                    $detalle->estado = 1;
                    $detalle->neto = $venta->valor - $venta->comision;
                    $detalle->save();
                }
            }
            $coniliacion->valor = $valor;
            $coniliacion->neto = $neto;
            $coniliacion->cantidad = $cant;
            $coniliacion->save();

            $caja->montocierre += $coniliacion->neto;
            $caja->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
        }

        return redirect()->back()->with('message', 'Conciliación creada satifactoriamente');
    }
}
