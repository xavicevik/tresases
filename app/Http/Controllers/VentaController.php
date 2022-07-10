<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmailJob;
use App\Models\Boleta;
use App\Models\Caja;
use App\Models\Comision;
use App\Models\Confcomision;
use App\Models\Detalleventa;
use App\Models\Loteria;
use App\Models\Imagen;
use App\Models\Pago;
use App\Models\Promoboleta;
use App\Models\Promocional;
use App\Models\Recibo;
use App\Models\Rifa;
use App\Models\Transaccion;
use App\Models\User;
use App\Models\Venta;
use Darryldecode\Cart\Cart;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use function PHPUnit\Framework\isEmpty;

class VentaController extends Controller
{
    function __construct()
    {
        /*
        $this->middleware('permission:ventas-list|ventas-create|ventas-edit|ventas-delete', ['only' => ['index','show']]);
        $this->middleware('permission:ventas-create', ['only' => ['create','store']]);
        $this->middleware('permission:ventas-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:ventas-delete', ['only' => ['destroy']]);
        */
        //$this->middleware(['role:Administrador','permission:ventas-list']);
        //$this->middleware('permission:ventas-list|ventas-create|ventas-edit|ventas-delete', ['only' => ['index','show']]);

    }

    const canPorPagina = 10;
    const debito = 'DB';
    const credito = 'CR';
    const pago = 'PA';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filtros = json_decode($request->filtros);

        $buscar = $request->buscar;
        if ($request->has('sortBy') && $request->sortBy <> ''){
            $sortBy = $request->sortBy;
        } else {
            $sortBy = 'ventas.id';
        }

        if ($request->has('sortOrder') && $request->sortOrder <> ''){
            $sortOrder = $request->sortOrder;
        } else {
            $sortOrder = 'desc';
        }

        if (is_null($filtros)){
            $ventas = Venta::orderBy($sortBy, $sortOrder)
                            ->with('puntoventa')
                            ->with('cliente')
                            ->with('vendedor')
                            ->paginate(self::canPorPagina);
        } else {
            $ventas = Venta::orderBy($sortBy, $sortOrder)
                            ->with('puntoventa')
                            ->with('cliente')
                            ->with('vendedor');

            if(!is_null($filtros->fechainicio) && $filtros->fechainicio <> '') {
                $ventas = $ventas->where('ventas.created_at', '>=', $filtros->fechainicio);
            }
            if(!is_null($filtros->fechafin) && $filtros->fechafin <> '') {
                $ventas = $ventas->where('ventas.created_at', '<=', $filtros->fechafin);
            }
            if(!is_null($filtros->cliente) && $filtros->cliente <> '') {
                $ventas = $ventas->join('users as t1', 'ventas.idcliente', '=', 't1.id')
                    ->where('t1.nombre', 'like', '%'.$filtros->cliente.'%')
                    ->orWhere('t1.apellido', 'like', '%'.$filtros->cliente.'%');
            }
            if(!is_null($filtros->vendedor) && $filtros->vendedor <> '') {
                $ventas = $ventas->join('users as t2', 'ventas.idvendedor', '=', 't2.id')
                    ->where('t2.nombre', 'like', '%'.$filtros->vendedor.'%')
                    ->orWhere('t2.apellido', 'like', '%'.$filtros->vendedor.'%');
            }
            if(!is_null($filtros->venta) && $filtros->venta <> '') {
                $ventas = $ventas->where('ventas.id', 'like', '%'.$filtros->venta.'%');
            }
            if(!is_null($filtros->puntoventa) && $filtros->puntoventa <> '') {
                $ventas = $ventas->join('puntos_ventas', 'ventas.idpuntoventa', '=', 'puntos_ventas.id')
                    ->where('puntos_ventas.nombre', 'like', '%'.$filtros->puntoventa.'%');
            }
            if(!is_null($filtros->comprobante)) {
                $ventas = $ventas->where('comprobante', 'like', '%'.$filtros->comprobante.'%');
            }
            if(!is_null($filtros->rifa)) {
                $ventas = $ventas->join('rifas', 'ventas.idrifa', '=', 'rifas.id')
                    ->where('rifas.nombre_tecnico', 'like', '%'.$filtros->rifa.'%')
                    ->select('ventas.*');
            }

            $ventas = $ventas->select('ventas.*')->paginate(self::canPorPagina);
        }

        //$this->authorizeResource(User::class);

        if ($request->has('ispage') && $request->ispage){
            return ['data' => $ventas];
        } else {
            return Inertia::render('Ventas/Index', ['data' => $ventas]);
        }
    }

    public function getDetalles(Request $request)
    {
        $detalle = Detalleventa::where('idventa', $request->id)
                        ->with('rifa')
                        ->with('cliente')
                        ->with('boleta')
                        ->paginate(self::canPorPagina);

       return ['data' => $detalle];
    }

    public function getDetallesHistorial(Request $request)
    {
        $ventas = Venta::where('idhistorial', $request->id)
            ->with('vendedor')
            ->with('cliente')
            ->paginate(self::canPorPagina);

        return ['data' => $ventas];
    }

    public function getComisiones(Request $request)
    {
        $comisiones = Comision::where('idventa', $request->id)
            ->with('configuracion')
            ->get();

        return ['data' => $comisiones];
    }

    public function sumary(Request $request)
    {
        $venta = Venta::where('id', $request->id)
                       ->with('detalles.boleta')
                       ->with('detalles.rifa')
                       ->with('cliente')
                       ->with('vendedor')
                       ->get();

        return Inertia::render('Ventas/Sumary', ['data' => $venta[0]]);

    }


    public function create(Request $request)
    {
        $mytime= Carbon::now('America/Bogota')->format('Y-m-d');

        if (Auth::user()->idrol == 5) {
            $caja = Caja::where('idvendedor', Auth::user()->id)
                        ->where('estado', 1)
                        ->where('fechaapertura', '>=', $mytime)
                        ->where('fechacierre', null)
                        ->first();

            if (is_null($caja)) {
                return redirect()->route('cajas.index', ['estado' => '1']);
            } else {
                return Inertia::render('Ventas/Venta',  ['estado' => '0']);
            }
        }
        return Inertia::render('Ventas/Venta');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');
/*
        Validator::make($request->all(), [
            'titulo' => 'required',
            'resolucion' => 'required',
            'descripcion' => 'required',
            'nombre_tecnico' => 'required',
            'idloteria' => 'required|numeric|gt:0',
            'idpais' => 'required|numeric|gt:0',
            'iddepartamento' => 'required|numeric|gt:0',
            'idciudad' => 'required|numeric|gt:0',
            'cifras' => 'required|numeric|gt:0',
            'precio' => 'required|numeric|gt:0',
            'fechainicio' => 'required',
            'fechafin' => 'required',
            'idterminos' => 'required|numeric|gt:0',
            'files1' => 'required',
            'files2' => 'required',
        ],
            [
                'titulo.required' => 'Ingrese el titulo',
                'resolucion.required' => 'Ingrese la resolucion',
                'descripcion.required' => 'Ingrese la descripcion',
                'nombre_tecnico.required' => 'Ingrese el nombre técnico',
                'idloteria.gt' => 'Seleccione una loteria',
                'idpais.gt' => 'Seleccione un País',
                'iddepartamento.gt' => 'Seleccione un Departamento',
                'idciudad.gt' => 'Seleccione una Ciudad',
                'cifras.required' => 'Ingrese la cantidad de cifras',
                'cifras.numeric' => 'La cantidad de fifras debe ser numerica',
                'cifras.gt' => 'Ingrese la cantidad de cifras',
                'precio.required' => 'Ingrese el precio',
                'precio.numeric' => 'El valor debe ser mayor a 0',
                'precio.gt' => 'El valor debe ser mayor a 0',
                'fechainicio.required' => 'Seleccione fecha de inicio',
                'fechainicio.required' => 'Seleccione fecha de fin',
                'files1.required' => 'Ingrese la imagen de rifa grande',
                'files2.required' => 'Ingrese la imagen de rifa pequeña',
                'idterminos.gt' => 'Seleccione un registro',

            ])->validate();
*/
        try{
            DB::beginTransaction();

            $mytime= Carbon::now('America/Bogota');

            $venta = new Venta();
            $venta->valorventa = $request->valortotal;
            $venta->impuesto = 0;
            $venta->comision = 0;
            $venta->valortotal = $request->valortotal;
            $venta->cantidad = $request->cantidad;
            $venta->idvendedor = Auth::user()->id;
            $venta->idcliente = $request->idcliente;
            $venta->idpuntoventa = $request->idpuntoventa;
            $venta->fechaventa = $mytime->toDateString();//$request->fechaventa;
            $venta->comprobante = $request->comprobante;
            $venta->estado = true;
            $venta->transaccion = 1;
            $venta->saveOrFail();

            \Cart::session(Auth::user()->id);
            $boletas = \Cart::getContent();

            if (isset($boletas) && sizeof($boletas) > 0) {
                foreach($boletas as $ep=>$det)
                {
                    Boleta::find($det['id'])->update(['estado' => 0]);

                    $detalleventa = new Detalleventa();
                    $detalleventa->idventa = $venta->id;
                    $detalleventa->idboleta = $det['id'];
                    $detalleventa->idrifa = $det['attributes']['idrifa'];
                    $detalleventa->valor = $det['price'];
                    $detalleventa->impuesto = 0;
                    $detalleventa->comision = 0;
                    $detalleventa->valortotal = $det['price'];
                    $detalleventa->numero = $det['attributes']['numero'];
                    $detalleventa->cantidad = $det['quantity'];
                    $detalleventa->estado = 1;
                    $detalleventa->saveOrFail();
                }
            }
            \Cart::clear();
            \Cart::session(Auth::user()->id)->clear();

            //return redirect()->route('enviar', ['notificacion' => $venta->id]);

            switch ($request->paymentmethod) {
                case 1:
                    $concepto = 4;
                    $descripcion = 'Pago con tarjeta crédito/debito';
                    break;
                case 2:
                    $concepto = 6;
                    $descripcion = 'Pago con transferencia';
                    break;
                case 3:
                    $concepto = 2;
                    $descripcion = 'Pago en efectivo';
                    break;
                default:
                    $concepto = 0;
                    $descripcion = '';
                    break;
            }
            $signo = self::debito;
            $impuesto = 0;

            $transaccion = new Transaccion();
            $transaccion->idusuarioori = $request->idcliente;
            $transaccion->idusuariodest = Auth::user()->id;
            $transaccion->idconcepto = $concepto;
            $transaccion->origen = 'Fisico';
            $transaccion->destino = 'Digital';
            $transaccion->signo = $signo;
            $transaccion->valor = $request->valorpagar;
            $transaccion->impuesto = $impuesto;
            $transaccion->descripcion = $descripcion;
            $transaccion->soporte = $request->comprobante;
            $transaccion->mes = $mytime->month;
            $transaccion->ano = $mytime->year;
            $transaccion->save();

            $pago = new Pago();
            $pago->idventa = $venta->id;
            $pago->valortotal = $request->valorpagar;
            $pago->idcliente = $venta->idcliente;
            $pago->idvendedor = Auth::user()->id;
            $pago->saldo = $venta->valortotal - $request->valorpagar;
            $pago->canal = 'Fisico';
            $pago->descripcion = $descripcion;
            $pago->tipo = 'Pago';
            $pago->soporte = $request->comprobante;
            $pago->idtransaccion = $transaccion->id;
            $pago->idpuntoventa = $request->idpuntoventa;
            $pago->idcaja = $request->session()->get('caja', 0)[0];
            $pago->save();

            $concomision = Confcomision::join('users as t1', 'confcomisiones.idvendedor', '=', 't1.idempresa')
                                        ->select('confcomisiones.*')
                                        ->where('t1.id', $venta->idvendedor)
                                        ->first();
            $comision = new Comision();
            $comision->idventa = $venta->id;
            $comision->idconfiguracion = $concomision->id;
            $comision->valorventa = $venta->valortotal;
            $comision->comisionmayorista = $venta->valortotal * ($concomision->comisionmayorista/100);
            $comision->comisiondistribuidor = $venta->valortotal * ($concomision->comisiondistribuidor/100);
            $comision->comisionvendedor = $venta->valortotal * ($concomision->comisionvendedor/100);
            $comision->estado = true;
            $comision->save();

            DB::commit();

            $subject = "TresAses - Venta # ".$venta->id;
            $for = $venta['cliente']->correo;
            $url = $request->url;

            $data = Venta::where('id', $venta->id)
                ->with('detalles.boleta')
                ->with('detalles.rifa')
                ->with('cliente')
                ->with('vendedor')
                ->get();
            $ventamail = $data[0];

            $data = array(
                'data'     => $ventamail,
                'subject'  => $subject,
                'for'      => $for,
            );

            SendEmailJob::dispatch($data);

        } catch (Throwable $e){
            DB::rollBack();
        }

        return redirect()->back()
            ->with(['message' => $venta->id]);
    }

    public function valBoletaLibre(Request $request) {
        $cifras = $request->cifras;
        $idrifa = $request->rifa;
        $numero = str_pad($request->buscar, $cifras,"0", STR_PAD_LEFT );
        $estado = true;

        $boleta = Boleta::where('idrifa', $idrifa)
                          ->where('estado', '<>', 1)
                          ->where('numero', $numero)
                          ->first();

        $promoboleta = Promoboleta::where('idrifa', $idrifa)
                              ->where('estado', '<>', 1)
                              ->where('numero', $numero)
                              ->get();

        if (is_null($boleta)) {
            $estado = false;
            $boleta = Boleta::where('idrifa', $idrifa)
                ->where('estado', '=', 1)
                ->where('numero', $numero)
                ->first();
        }
        return ['boleta' => $boleta, 'promoboleta' => $promoboleta, 'isocupado' => $estado];

    }

    public function getRandBoletaLibre(Request $request) {
        $idrifa = $request->rifa;
        $tiporifa = $request->tiporifa;

        $bolval = Boleta::where('estado', 1)
                           ->where('idrifa', $idrifa)
                           ->count();
        if ($bolval == 0) {
            $boleta = -99;
        } else {
            $boleta = Boleta::where('estado', 1)
                                ->where('idrifa', $idrifa)
                                ->inRandomOrder()
                                ->first();
        }

        return ['boleta' => $boleta];
    }

    public function reportpdf(Request $request)
    {
        $venta = Venta::where('id', $request->id)
            ->with('detalles.boleta')
            ->with('detalles.rifa')
            ->with('cliente')
            ->with('vendedor')
            ->get();

        $data = [
            'cliente'  => $venta[0]['cliente'],
            'vendedor' => $venta[0]['vendedor'],
            'detalles' => $venta[0]['detalles'],
            'venta'    => $venta[0]
        ];

        $pdf = app('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->loadView('pdf.reportpdf', $data);

        return $pdf->download('pruebapdf.pdf');
        //return $pdf->stream('ventas.pdf');
    }

    public function reportpdfRegistroMov(Request $request)
    {
        try {
            // Begin a transaction
            DB::beginTransaction();
            $user = Auth::user();
            $totalventa = 0;
            $totalpagado = 0;
            $toatlcomision = 0;
            $mytime= Carbon::now('America/Bogota');

            $concomision = Confcomision::where('idvendedor', $request->idvendedor)
                                        ->where('estado', 2)
                                        ->first();
            if (is_null($concomision)) {
                $concomision = Confcomision::join('users as t1', 'confcomisiones.idvendedor', '=', 't1.idempresa')
                    ->select('confcomisiones.*')
                    ->where('t1.id', $request->idvendedor)
                    ->first();
            }

            $venta = new Venta();
            $venta->valorventa = 0;
            $venta->impuesto = 0;
            $venta->comision = 0;
            $venta->valortotal = 0;
            $venta->cantidad = 0;
            $venta->idvendedor = $request->idvendedor;
            $venta->idcliente = null;
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
                $boleta->idvendedor = $request->idvendedor;
                $boleta->idcliente = $reg->idcliente;
                $boleta->pago = $boleta->pago + $reg->valorpagar;
                $boleta->saldo = $boleta->valor - $boleta->pago;
                if ($boleta->saldo == 0) {
                    $boleta->estado = 3;
                } else {
                    $boleta->estado = 4;
                }
                $boleta->save();

                $detalleventa = new Detalleventa();
                $detalleventa->idventa = $venta->id;
                $detalleventa->idboleta = $boleta->id;
                $detalleventa->idrifa = $request->idrifa;
                $detalleventa->valor = $reg->valorpagar;
                $detalleventa->idcliente = $reg->idcliente;
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
            $transaccion->idusuarioori = $request->idvendedor;
            $transaccion->idusuariodest = Auth::user()->id;
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
            $pago->idcliente = null;
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
            DB::commit();

            return ['url' => url('/storage/pdf/').'/'.$filename];
        } catch (\Exception $e) {
            // An error occured; cancel the transaction...
            DB::rollback();

            // return redirect()->back()->withErrors(['error' => 'No se pudo registrar la venta, por favor validar los parámetros ingresados']);
            return back()->withErrors(['error' => ['No se pudo registrar la venta, por favor validar los parámetros ingresados']]);
            // and throw the error again.
            //throw $e;
        }
    }

    public function reportpdfAnulaMov(Request $request)
    {
        try {
            // Begin a transaction
            DB::beginTransaction();

            $user = Auth::user();
            $totalventa = 0;
            $totalpagado = 0;
            $toatlcomision = 0;
            $totaldevuelto = 0;
            $mytime= Carbon::now('America/Bogota');

            $concomision = Confcomision::where('idvendedor', $request->idvendedor)
                ->where('estado', 2)
                ->first();
            if (is_null($concomision)) {
                $concomision = Confcomision::join('users as t1', 'confcomisiones.idvendedor', '=', 't1.idempresa')
                    ->select('confcomisiones.*')
                    ->where('t1.id', $request->idvendedor)
                    ->first();
            }

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
            $venta->estado = 9;
            $venta->transaccion = $request->idcaja;
            $venta->save();

            foreach ($request->reservas as $reserva){
                $reg = json_decode($reserva);

                $boleta = Boleta::where('idrifa', $request->idrifa)
                    ->whereIn('estado', [3,4])
                    ->where('numero', $reg->numero)
                    ->where('idvendedor', $request->idvendedor)
                    ->first();
                $reg->comision = -$reg->valorpagado * ($concomision->comisionvendedor/100);
                $toatlcomision += $reg->comision;
                $salida[] = $reg;
                $totalventa += $boleta->valor;
                $totalpagado += $reg->valorpagado;
                $boleta->pago = $boleta->pago - $reg->valorpagado;
                $boleta->saldo = $boleta->valor - $boleta->pago;

                $idclientetmp = $boleta->idcliente;
                if ($boleta->pago == 0) {
                    $boleta->estado = 2;
                    $boleta->idvendedor = $request->idvendedor;
                    $boleta->idcliente = null;
                } else {
                    $boleta->estado = 3;
                    $boleta->idvendedor = $request->idvendedor;
                }
                if ($boleta->saldo == 0) {
                    $boleta->estado = 3;
                } else {
                    $boleta->estado = 4;
                }
                $boleta->save();

                $detalleventa = new Detalleventa();
                $detalleventa->idventa = $venta->id;
                $detalleventa->idboleta = $boleta->id;
                $detalleventa->idrifa = $request->idrifa;
                $detalleventa->valor = -$reg->valorpagado;
                $detalleventa->idcliente = $idclientetmp;
                $detalleventa->impuesto = 0;
                $detalleventa->comision = -$reg->comision;
                $detalleventa->valortotal = $boleta->valor;
                $detalleventa->numero = $reg->numero;
                $detalleventa->cantidad = 1;
                $detalleventa->estado = 9;
                $detalleventa->save();

                $reg->valorpagado = "$" . number_format($reg->valorpagado, 0, ".", ",");
                $reg->comision = "$" . number_format($reg->comision, 0, ".", ",");
            }
            $recibo = new Recibo();
            $recibo->nombre = 'Recibo anulacion venta';
            $recibo->url = 'Recibo anulacion venta';
            $recibo->idusuario = Auth::user()->id;
            $recibo->iduserdestino = $request->idvendedor;
            $recibo->save();

            $detalleventa->idventa = $venta->id;
            $detalleventa->save();

            $comision = new Comision();
            $comision->idventa = $venta->id;
            $comision->idconfiguracion = $concomision->id;
            $comision->valorventa = -$totalpagado;
            $comision->comisionmayorista = -$totalpagado * ($concomision->comisionmayorista/100);
            $comision->comisiondistribuidor = -$totalpagado * ($concomision->comisiondistribuidor/100);
            $comision->comisionvendedor = -$totalpagado * ($concomision->comisionvendedor/100);
            $comision->estado = true;
            $comision->save();

            $venta->comision = $comision->comisionmayorista + $comision->comisiondistribuidor + $comision->comisionvendedor;
            $venta->valorventa = -$totalpagado;
            $venta->valortotal = $totalventa;
            $venta->cantidad = sizeof($salida);
            $venta->save();

            $concepto = 5;
            $descripcion = 'Anulación Pago en efectivo';
            $signo = self::credito;
            $impuesto = 0;

            $transaccion = new Transaccion();
            $transaccion->idusuarioori = $request->idvendedor;
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
            $pago->tipo = 'Devolucion Pago';
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
                'comisionvendedor' => "$" . number_format($comision->comisionvendedor, 0, ".", ","),
                'valortotal' => "$" . number_format($venta->valorventa, 0, ".", ","),
                'valorentregar' => "$" . number_format($venta->valorventa - $comision->comisionvendedor, 0, ".", ","),
                'cantidad' => sizeof($salida)
            ];

            $filename = 'reciboAnulacionVenta_'.$data['recibo'].'.pdf';
            $recibo->url = $filename;
            $recibo->save();
            $pdf = app('dompdf.wrapper');
            $pdf->getDomPDF()->set_option("enable_php", true);
            $pdf->loadView('pdf.reportpdfAnulacionVenta', $data);

            $output = $pdf->output();
            file_put_contents(public_path('storage').'/pdf/'.$filename, $output, FILE_APPEND);
            $venta->urlrecibo = url('/storage/pdf/').'/'.$filename;
            $venta->save();

            DB::commit();

            return ['url' => url('/storage/pdf/').'/'.$filename];
        } catch (\Exception $e) {
            // An error occured; cancel the transaction...
            DB::rollback();

            return back()->withErrors(['error' => ['No se pudo registrar la venta, por favor validar los parámetros ingresados']]);
            // and throw the error again.
            //throw $e;
        }

    }

}
