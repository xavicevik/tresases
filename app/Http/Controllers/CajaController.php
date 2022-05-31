<?php

namespace App\Http\Controllers;

use App\Models\Caja;
use App\Models\Historialcaja;
use App\Models\Pago;
use App\Models\Rol;
use App\Models\User;
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

    public function open(Request $request)
    {
        $cajas = Caja::select('estado', DB::raw('count(1) as cantidad'))
                      ->groupBy('estado')
                      ->get();

        return ['cajas' => $cajas];
    }

    public function apertura(Request $request)
    {
        $mytime= Carbon::now('America/Bogota');
        $caja = $request->session()->pull('caja', 0);

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

        return redirect()->back()
                         ->with(['message' => 'Caja abierta']);
    }

    public function cierre(Request $request)
    {
        $mytime= Carbon::now('America/Bogota');

        $cajas = Caja::where('id', $request->id)
                      ->firstOrFail();
        $vendedor = $cajas->idvendedor;
        $cajas->estado = 0;
        $cajas->idvendedor = 0;
        $cajas->montocierre = $request->montocierre;
        $cajas->fechacierre = $mytime->toDateTimeString();;
        $cajas->save();

        $recaudoefectivo = Pago::where('idcaja', $cajas->id)
                      ->whereDate('created_at',  Carbon::create($cajas->fechaapertura)->toDateString())
                      ->sum('valortotal');

        $histocaja = new Historialcaja();
        $histocaja->idcaja = $cajas->id;
        $histocaja->idvendedor = $vendedor;
        $histocaja->idpuntoventa = $cajas->idpuntoventa;
        $histocaja->montoapertura = $cajas->montoapertura;
        $histocaja->montocierre = $cajas->montocierre;
        $histocaja->recaudoefectivo = $recaudoefectivo;
        $histocaja->fechaapertura = $cajas->fechaapertura;
        $histocaja->fechacierre = $cajas->fechacierre;
        $histocaja->faltante = ($recaudoefectivo - $cajas->montocierre) > 0? ($recaudoefectivo - $cajas->montocierre):0;
        $histocaja->sobrante = ($cajas->montocierre - $recaudoefectivo) > 0? ($cajas->montocierre - $recaudoefectivo):0;
        $histocaja->estado = true;
        $histocaja->saveOrFail();

        $histocaja = Historialcaja::where('id', $histocaja->id)
                                  ->with('vendedor')
                                  ->with('puntoventa')->first();

        $request->session()->pull('caja', '');

        return ['histocaja' => $histocaja];
    }

}
