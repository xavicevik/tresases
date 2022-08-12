<?php

namespace App\Http\Controllers;

use App\Models\Boleta;
use App\Models\Caja;
use App\Models\Comision;
use App\Models\Confcomision;
use App\Models\Detalleventa;
use App\Models\Historialcaja;
use App\Models\Pago;
use App\Models\Recibo;
use App\Models\Rol;
use App\Models\Transaccion;
use App\Models\User;
use App\Models\Venta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Laravel\Jetstream\Jetstream;

class CajaController extends Controller
{
    const canPorPagina = 10;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
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
            $cajas = Caja::orderBy($sortBy, $sortOrder)
                        ->leftJoin('users', 'cajas.idvendedor', '=', 'users.id')
                        ->with('puntoventa')
                        ->select('cajas.*', 'users.username');
        } else {
            $cajas = Caja::orderBy($sortBy, $sortOrder)
                        ->leftJoin('users', 'cajas.idvendedor', '=', 'users.id')
                        ->with('puntoventa')
                        ->select('cajas.*', 'users.username');
        }

        if (Auth::user()->idrol == 5) {
            $cajas = $cajas->where('idpuntoventa', Session::get('puntodeventa'));
            $cajas = $cajas->paginate(self::canPorPagina);
        } else {
            $cajas = $cajas->paginate(self::canPorPagina);
        }

        if ($request->has('ispage') && $request->ispage){
            return ['cajas' => $cajas];
        } else {
            return Inertia::render('Cajas/Index', ['cajas' => $cajas, 'estado' => $request->estado]);
        }
    }

    public function historial(Request $request)
    {
        $filtros = json_decode($request->filtros);
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
                ->with('puntoventa');
        } else {
            $cajas = Historialcaja::orderBy($sortBy, $sortOrder)
                ->with('caja')
                ->with('vendedor')
                ->with('puntoventa');
        }

        if (!is_null($filtros)){
            if(!is_null($filtros->fechainicio) && $filtros->fechainicio <> '') {
                $cajas = $cajas->where('historialcajas.created_at', '>=', $filtros->fechainicio);
            }
            if(!is_null($filtros->fechafin) && $filtros->fechafin <> '') {
                $cajas = $cajas->where('historialcajas.created_at', '<=', $filtros->fechafin);
            }

            if(!is_null($filtros->vendedor) && $filtros->vendedor <> '') {
                $cajas = $cajas->join('users as t2', 'historialcajas.idvendedor', '=', 't2.id')
                    ->where('t2.nombre', 'like', '%'.$filtros->vendedor.'%')
                    ->orWhere('t2.apellido', 'like', '%'.$filtros->vendedor.'%');
            }
            if(!is_null($filtros->puntoventa) && $filtros->puntoventa <> '') {
                $cajas = $cajas->join('puntos_ventas', 'historialcajas.idpuntoventa', '=', 'puntos_ventas.id')
                    ->where('puntos_ventas.nombre', 'like', '%'.$filtros->puntoventa.'%');
            }
        }

        $cajas = $cajas->paginate(self::canPorPagina);

        if ($request->has('ispage') && $request->ispage){
            return ['cajas' => $cajas];
        } else {
            return Inertia::render('Cajas/Historial', ['cajas' => $cajas, 'estado' => $request->estado]);
        }
    }

    public function getHistorial(Request $request)
    {
        //DB::connection()->enableQueryLog();
        $filtros = json_decode($request->filtros);
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

        $cajas = Historialcaja::orderBy($sortBy, $sortOrder)
            ->with('caja')
            ->with('vendedor')
            ->with('puntoventa');

        if (!is_null($filtros)){
            if(!is_null($filtros->fechainicio) && $filtros->fechainicio <> '') {
                $cajas = $cajas->where('historialcajas.created_at', '>=', $filtros->fechainicio);
            }
            if(!is_null($filtros->fechafin) && $filtros->fechafin <> '') {
                $cajas = $cajas->where('historialcajas.created_at', '<=', $filtros->fechafin);
            }

            if(!is_null($filtros->vendedor) && $filtros->vendedor <> '') {
                $cajas = $cajas->join('users as t2', 'historialcajas.idvendedor', '=', 't2.id')
                    ->where('t2.nombre', 'like', '%'.$filtros->vendedor.'%')
                    ->orWhere('t2.apellido', 'like', '%'.$filtros->vendedor.'%');
            }
            if(!is_null($filtros->puntoventa) && $filtros->puntoventa <> '') {
                $cajas = $cajas->join('puntos_ventas', 'historialcajas.idpuntoventa', '=', 'puntos_ventas.id')
                               ->where('puntos_ventas.nombre', 'like', '%'.$filtros->puntoventa.'%');
            }
        }

        $cajas = $cajas->paginate(self::canPorPagina);

        //$queries = \DB::getQueryLog();
        //dd($queries);

        return ['data' => $cajas];
    }

    public function open(Request $request)
    {
        $cajas = Caja::select('estado', DB::raw('count(1) as cantidad'))
                      ->groupBy('estado')
                      ->get();

        $ventas = Venta::select(DB::raw('SUM(valorventa) as valor, SUM(cantidad) cantidad'))
                         ->whereDate('fechaventa', '=', Carbon::today()->toDateString())
                         ->get();

        return ['cajas' => $cajas, 'stats' => $ventas];
    }

    public function apertura(Request $request)
    {
        $mytime= Carbon::now('America/Bogota');
        $caja = $request->session()->pull('caja', 0);
        $status = false;

        $cajas = Caja::where('idvendedor', Auth::user()->id)
                      ->where('estado', 1)
                      ->first();
        if (is_null($cajas)) {
            $status = true;
            $cajas = Caja::where('id', $request->id)
                ->firstOrFail();
            $cajas->estado = 1;
            $cajas->idvendedor = Auth::user()->id;
            $cajas->montoapertura = $request->montoapertura;
            $cajas->fechaapertura = $mytime->toDateTimeString();
            $cajas->fechacierre = null;
            $cajas->montocierre = 0.0;
            $cajas->save();

            $request->session()->push('caja', $cajas->id);
        } else {
            $status = false;
        }
        return ['status' => $status, 'caja' => $cajas->id];
        //return redirect()->back()
        //                 ->with(['message' => 'Caja abierta']);
    }

    public function cierre(Request $request)
    {
        $mytime= Carbon::now('America/Bogota');
        $cajas = Caja::where('id', $request->idcaja)
                      ->firstOrFail();
        $cajas->estado = 0;
        $cajas->montocierre = $request->montocierre;
        $cajas->fechacierre = $mytime->toDateTimeString();;
        $cajas->save();

        $ventas = Venta::with('puntoventa')
            ->with('cliente')
            ->with('vendedor')
            ->where('idpuntoventa', $cajas->idpuntoventa)
            ->where('transaccion', $cajas->id)
            ->where('fechaventa', '>=', Carbon::create($cajas->fechaapertura)->toDateTimeString())
            ->get();

        $histocaja = new Historialcaja();
        $histocaja->idcaja = $cajas->id;
        $histocaja->idvendedor = $cajas->idvendedor;
        $histocaja->idpuntoventa = $cajas->idpuntoventa;
        $histocaja->montoapertura = $cajas->montoapertura;
        $histocaja->montocierre = $cajas->montocierre;
        $histocaja->recaudoefectivo = 0;
        $histocaja->fechaapertura = $cajas->fechaapertura;
        $histocaja->fechacierre = $cajas->fechacierre;
        $histocaja->faltante = 0;
        $histocaja->sobrante = 0;
        $histocaja->estado = true;
        $histocaja->save();

        $totaltransaccion = 0;
        $totalcomisiones = 0;
        $totalboletas = 0;
        foreach($ventas as $venta) {
            $totaltransaccion += $venta->valorventa;
            $totalcomisiones += $venta->comision;
            $totalboletas += $venta->cantidad;
            $venta->idhistorial = $histocaja->id;
            $venta->save();
        }

        $histocaja->comisionventa = $totalcomisiones;
        $histocaja->recaudoefectivo = $totaltransaccion;
        $histocaja->faltante = ($totaltransaccion - $totalcomisiones - $cajas->montocierre) > 0? ($totaltransaccion - $totalcomisiones - $cajas->montocierre):0;
        $histocaja->sobrante = ($cajas->montocierre - $totaltransaccion + $totalcomisiones) > 0? ($cajas->montocierre - $totaltransaccion + $totalcomisiones):0;
        $histocaja->save();

        $histocaja = Historialcaja::where('id', $histocaja->id)
                                  ->with('vendedor')
                                  ->with('puntoventa')->first();
        $request->session()->pull('caja', '');

        return ['histocaja' => $histocaja];
    }

    public function movimientos(Request $request)
    {
        $filtros = json_decode($request->filtros);

        $buscar = $request->buscar;
        if ($request->has('sortBy') && $request->sortBy <> ''){
            $sortBy = $request->sortBy;
        } else {
            $sortBy = 'ventas.id';
        }

        $caja = Caja::where('idvendedor', Auth::user()->id)
                        ->with('puntoventa')
                        ->where('estado', 1)
                        ->first();
        if ($request->has('sortOrder') && $request->sortOrder <> ''){
            $sortOrder = $request->sortOrder;
        } else {
            $sortOrder = 'desc';
        }

        if (is_null($caja)) {
            return redirect()->route('cajas.index', ['estado' => '1']);
        }

        $ventas = Venta::orderBy($sortBy, $sortOrder)
            ->with('puntoventa')
            ->with('cliente')
            ->with('vendedor')
            ->where('idpuntoventa', $caja->idpuntoventa)
            ->where('transaccion', $caja->id)
            ->where('fechaventa', '>=', Carbon::create($caja->fechaapertura)->toDateTimeString())
            ->paginate(self::canPorPagina);

        $totaltransaccion = 0;
        $totalcomisiones = 0;
        $totalboletas = 0;
        foreach($ventas as $venta) {
            $totaltransaccion += $venta->valorventa;
            $totalcomisiones += $venta->comision;
            $totalboletas += $venta->cantidad;
        }

        if ($request->has('ispage') && $request->ispage){
            return [
                        'datos' => $ventas,
                        'caja' => $caja,
                        'estado' => $request->estado,
                        'totaltransaccionprop' => $totaltransaccion,
                        'totalcomisionesprop' => $totalcomisiones,
                        'totalboletas' => $totalboletas
                    ];
        } else {
            return Inertia::render('Cajas/Movimientos', [
                                                        'datos' => $ventas,
                                                        'caja' => $caja,
                                                        'estado' => $request->estado,
                                                        'totaltransaccionprop' => $totaltransaccion,
                                                        'totalcomisionesprop' => $totalcomisiones,
                                                        'totalboletas' => $totalboletas
                                                        ]);
        }
    }

    public function printcierre(Request $request)
    {
        $recaudocaja = json_decode($request->recaudocaja);

        $recibo = new Recibo();
        $recibo->nombre = 'Resumen cierre caja';
        $recibo->url = 'Resumen cierre caja';
        $recibo->idusuario = Auth::user()->id;
        $recibo->iduserdestino = Auth::user()->id;
        $recibo->save();

        $recaudocaja->fondo = "$" . number_format($recaudocaja->montoapertura, 0, ".", ",");
        $recaudocaja->montocierre = "$" . number_format($recaudocaja->montocierre, 0, ".", ",");
        $recaudocaja->recaudoefectivo = "$" . number_format($recaudocaja->recaudoefectivo, 0, ".", ",");
        $recaudocaja->comisionventa = "$" . number_format($recaudocaja->comisionventa, 0, ".", ",");
        $recaudocaja->faltante = "$" . number_format($recaudocaja->faltante, 0, ".", ",");
        $recaudocaja->sobrante = "$" . number_format($recaudocaja->sobrante, 0, ".", ",");

        $data = [
            'recaudocaja' => $recaudocaja,
            'fecha' => $recibo->created_at,
            'recibo'  => $recibo->id,
        ];

        $filename = 'reciboResumencierre_'.$data['recibo'].'.pdf';
        $recibo->url = $filename;
        $recibo->save();
        $pdf = app('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->loadView('pdf.reportpdfCierreCaja', $data);

        $output = $pdf->output();
        file_put_contents(public_path('storage').'/pdf/'.$filename, $output, FILE_APPEND);

        return ['url' => url('/storage/pdf/').'/'.$filename];
    }

}
