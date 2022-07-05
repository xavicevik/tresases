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
    const canPorPagina = 15;
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

        $ventas = Venta::select(DB::raw('SUM(valorventa) as valor, SUM(cantidad) cantidad'))
                         ->whereDate('fechaventa', '=', Carbon::today()->toDateString())
                         ->get();

        return ['cajas' => $cajas, 'stats' => $ventas];
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
                        'totaltransaccion' => $totaltransaccion,
                        'totalcomisiones' => $totalcomisiones,
                        'totalboletas' => $totalboletas
                    ];
        } else {
            return Inertia::render('Cajas/Movimientos', [
                                                        'datos' => $ventas,
                                                        'caja' => $caja,
                                                        'estado' => $request->estado,
                                                        'totaltransaccion' => $totaltransaccion,
                                                        'totalcomisiones' => $totalcomisiones,
                                                        'totalboletas' => $totalboletas
                                                        ]);
        }
    }

    public function reportpdfCierreCaja(Request $request)
    {
        $user = Auth::user();
        $totalventa = 0;
        $totalpagado = 0;
        $toatlcomision = 0;
        $mytime= Carbon::now('America/Bogota');

        $concomision = Confcomision::join('users as t1', 'confcomisiones.idvendedor', '=', 't1.idempresa')
            ->select('confcomisiones.*')
            ->where('t1.id', $request->idvendedor)
            ->first();
        $venta = new Venta();
        $venta->valorventa = 0;
        $venta->impuesto = 0;
        $venta->comision = 0;
        $venta->valortotal = 0;
        $venta->cantidad = 0;
        $venta->idvendedor = $request->idvendedor;
        $venta->idcliente = $request->idcliente;
        $venta->idpuntoventa = $request->idpuntoventa;
        $venta->fechaventa = $mytime->toDateTimeString();
        $venta->comprobante = $request->comprobante;
        $venta->estado = 3;
        $venta->transaccion = $request->idcaja;
        $venta->save();

        foreach ($request->reservas as $reserva){
            $reg = json_decode($reserva);
            $boleta = Boleta::where('idrifa', $request->idrifa)
                //->where('estado', '=', 2)
                ->where('numero', $reg->numero)
                //->where('idvendedor', $request->idvendedor)
                ->first();
            $reg->comision = $reg->valorpagar * ($concomision->comisionvendedor/100);
            $toatlcomision += $reg->comision;
            $salida[] = $reg;
            $totalventa += $boleta->valor;
            $totalpagado += $reg->valorpagar;
            $boleta->estado = 3;
            $boleta->idvendedor = $request->idvendedor;
            $boleta->idcliente = $request->idcliente;
            $boleta->pago = $boleta->pago + $reg->valorpagar;
            $boleta->saldo = $boleta->valor - $boleta->pago;
            $boleta->save();

            $detalleventa = new Detalleventa();
            $detalleventa->idventa = $venta->id;
            $detalleventa->idboleta = $boleta->id;
            $detalleventa->idrifa = $request->idrifa;
            $detalleventa->valor = $reg->valorpagar;
            $detalleventa->idcliente = $request->idcliente;
            $detalleventa->impuesto = 0;
            $detalleventa->comision = $reg->comision;
            $detalleventa->valortotal = $boleta->valor;
            $detalleventa->numero = $reg->numero;
            $detalleventa->cantidad = 1;
            $detalleventa->estado = 3;
            $detalleventa->save();

            $reg->valorpagar = "$" . number_format($reg->valorpagar, 0, ".", ",");
            $reg->comision = "$" . number_format($reg->comision, 0, ".", ",");
        }
        $recibo = new Recibo();
        $recibo->nombre = 'Recibo venta';
        $recibo->url = 'Recibo venta';
        $recibo->idusuario = Auth::user()->id;
        $recibo->iduserdestino = $request->idvendedor;
        $recibo->save();

        $detalleventa->idventa = $venta->id;
        $detalleventa->save();

        $comision = new Comision();
        $comision->idventa = $venta->id;
        $comision->idconfiguracion = $concomision->id;
        $comision->valorventa = $totalpagado;
        $comision->comisionmayorista = $totalpagado * ($concomision->comisionmayorista/100);
        $comision->comisiondistribuidor = $totalpagado * ($concomision->comisiondistribuidor/100);
        $comision->comisionvendedor = $totalpagado * ($concomision->comisionvendedor/100);
        $comision->estado = true;
        $comision->save();

        $venta->comision = $comision->comisionmayorista + $comision->comisiondistribuidor + $comision->comisionvendedor;
        $venta->valorventa = $totalpagado;
        $venta->valortotal = $totalventa;
        $venta->cantidad = sizeof($salida);
        $venta->save();

        $concepto = 2;
        $descripcion = 'Pago en efectivo';
        $signo = self::debito;
        $impuesto = 0;

        $transaccion = new Transaccion();
        $transaccion->idusuarioori = $request->idcliente;
        $transaccion->idusuariodest = $request->idvendedor;
        $transaccion->idconcepto = $concepto;
        $transaccion->origen = 'Fisico';
        $transaccion->destino = 'Fisico';
        $transaccion->signo = $signo;
        $transaccion->valor = $venta->valorventa;
        $transaccion->impuesto = $impuesto;
        $transaccion->descripcion = $descripcion;
        $transaccion->soporte = $request->comprobante;
        $transaccion->mes = $mytime->month;
        $transaccion->ano = $mytime->year;
        $transaccion->save();

        $pago = new Pago();
        $pago->idventa = $venta->id;
        $pago->valortotal = $venta->valorventa;
        $pago->idcliente = $request->idcliente;
        $pago->idvendedor = $request->idvendedor;
        $pago->saldo = $venta->valortotal - $venta->valorventa;
        $pago->canal = 'Fisico';
        $pago->descripcion = $descripcion;
        $pago->tipo = 'Pago';
        $pago->soporte = $request->comprobante;
        $pago->idtransaccion = $transaccion->id;
        $pago->idpuntoventa = $request->idpuntoventa;
        $pago->idcaja = $request->idcaja;
        $pago->save();

        $data = [
            'vendedor' => $request->vendedor,
            'usuario' => $user->username,
            'rifa' => $request->rifa,
            'fecha' => $recibo->created_at,
            'reservas' => $salida,
            'recibo'  => $recibo->id,
            'comisionvendedor' => "-$" . number_format($comision->comisionvendedor, 0, ".", ","),
            'valortotal' => "$" . number_format($venta->valorventa, 0, ".", ","),
            'valorentregar' => "$" . number_format($venta->valorventa - $comision->comisionvendedor, 0, ".", ","),
            'cantidad' => sizeof($salida)
        ];

        $filename = 'reciboVenta_'.$data['recibo'].'.pdf';
        $recibo->url = $filename;
        $recibo->save();
        $pdf = app('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->loadView('pdf.reportpdfVenta', $data);

        $output = $pdf->output();
        file_put_contents(public_path('storage').'/pdf/'.$filename, $output, FILE_APPEND);
        $venta->urlrecibo = url('/storage/pdf/').'/'.$filename;
        $venta->save();

        //return $pdf->download($filename);
        //return $pdf->stream('ventas.pdf');
        //return redirect()->back()->with(['message' => public_path('storage').'/pdf/'.$filename]);
        return ['url' => url('/storage/pdf/').'/'.$filename];
    }

}
