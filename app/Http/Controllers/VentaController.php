<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmailJob;
use App\Models\Boleta;
use App\Models\Caja;
use App\Models\Cliente;
use App\Models\Comision;
use App\Models\Confcomision;
use App\Models\Detallesesion;
use App\Models\Detalleventa;
use App\Models\Historialcaja;
use App\Models\Loteria;
use App\Models\Imagen;
use App\Models\Pago;
use App\Models\Promoboleta;
use App\Models\Promocional;
use App\Models\Recibo;
use App\Models\Rifa;
use App\Models\Sesionventa;
use App\Models\Transaccion;
use App\Models\User;
use App\Models\Vendedor;
use App\Models\Venta;
use Darryldecode\Cart\Cart;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
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
        $ventas = Venta::join('vendedors', 'vendedors.id', 'ventas.idvendedor')
            ->where('idhistorial', $request->id)
            ->select('ventas.*', DB::raw('CONCAT(vendedors.nombre, " ", vendedors.apellido) AS full_name'))
            ->paginate(self::canPorPagina);
        /*
        $ventas = Venta::join('usersviews', 'usersviews.id', 'ventas.idvendedor')
            ->where('idhistorial', $request->id)
            ->select('ventas.*', 'usersviews.full_name')
            ->paginate(self::canPorPagina);
        */
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

        $caja = Caja::where('idvendedor', Auth::user()->id)
            ->with('puntoventa')
            ->where('estado', 1)
            ->first();

        if (is_null($caja)) {
            return redirect()->route('cajas.index', ['estado' => '1']);
        }

        return Inertia::render('Ventas/Venta', [
            'caja' => $caja,
            'estado' => 0,
        ]);
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

    private function getSalesComision($idvendedor) {
        $concomision = Confcomision::where('idvendedor', $idvendedor)
            ->where('estado', 2)
            ->first();
        if (is_null($concomision)) {
            $concomision = Confcomision::join('vendedors as t1', 'confcomisiones.idvendedor', '=', 't1.idempresa')
                ->select('confcomisiones.*')
                ->where('t1.id', $idvendedor)
                ->first();
        }
        return $concomision;
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

            $idsesion = $request->idsesion;
            $session = Sesionventa::where('id', $idsesion)->first();

            DB::connection()->enableQueryLog();

            if($session) {
                $boletas = Boleta::join('detallesesion', 'detallesesion.idboleta', 'boletas.id')
                    ->join('clientes', 'detallesesion.idcliente', 'clientes.id')
                    ->where('detallesesion.idsesionventa', $session->id)
                    ->select('detallesesion.id as iddetalle',
                             'detallesesion.idsesionventa',
                             'detallesesion.valor',
                             'detallesesion.idcliente as idclienteboleta',
                             'boletas.id',
                             'boletas.pago',
                             'boletas.estado',
                             'boletas.saldo',
                             'boletas.numero',
                             'boletas.promocional',
                             'boletas.valor as valortotal',
                             'boletas.estado',
                             'boletas.idcliente',
                              DB::raw('CONCAT(clientes.nombre, " ", clientes.apellido) AS full_name')
                    )
                    ->get();
                $concomision = $this->getSalesComision($session->idvendedor);

                $venta = new Venta();
                $venta->valorventa = 0;
                $venta->impuesto = 0;
                $venta->comision = 0;
                $venta->valortotal = 0;
                $venta->cantidad = 0;
                $venta->idvendedor = $session->idvendedor;
                $venta->idcliente = null;
                $venta->idpuntoventa = $session->idpuntoventa;
                $venta->fechaventa = $mytime->toDateTimeString();
                $venta->comprobante = $request->comprobante;
                $venta->estado = 3;
                $venta->transaccion = $request->idcaja;
                $venta->save();

                foreach ($boletas as $boleta){
                    $toatlcomision += $boleta->valor * ($concomision->comisionvendedor/100);
                    $totalventa += $boleta->valortotal;
                    $totalpagado += $boleta->valor;
                    $boleta->idvendedor = $session->idvendedor;
                    $boleta->idcliente = $boleta->idclienteboleta;
                    $boleta->pago = $boleta->pago + $boleta->valor;
                    $boleta->saldo = $boleta->valortotal - $boleta->pago;
                    if ($boleta->saldo == 0) {
                        $estado = 3;
                    } else {
                        $estado = 4;
                    }
                    $boleta->estado = $estado;
                    $boleta->save();

                    $detalleventa = new Detalleventa();
                    $detalleventa->idventa = $venta->id;
                    $detalleventa->idboleta = $boleta->id;
                    $detalleventa->idrifa = $session->idrifa;
                    $detalleventa->valor = $boleta->valor;
                    $detalleventa->idcliente = $boleta->idcliente;
                    $detalleventa->impuesto = 0;
                    $detalleventa->comision = $boleta->valor * ($concomision->comisionvendedor/100);
                    $detalleventa->valortotal = $boleta->valortotal;
                    $detalleventa->numero = $boleta->numero;
                    $detalleventa->cantidad = 1;
                    $detalleventa->estado = 3;
                    $detalleventa->save();
                    $boleta['comision'] = $boleta->valor * ($concomision->comisionvendedor/100);
                    $salida[] = $boleta;
                }

                $queries = \DB::getQueryLog();
                //dd($queries);

                asort($salida);
                $recibo = new Recibo();
                $recibo->nombre = 'Recibo venta';
                $recibo->url = 'Recibo venta';
                $recibo->idusuario = Auth::user()->id;
                $recibo->iduserdestino = $session->idvendedor;
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
                $venta->cantidad = sizeof($boletas);
                $venta->save();

                $concepto = 2;
                $descripcion = 'Pago en efectivo';
                $signo = self::debito;
                $impuesto = 0;

                $transaccion = new Transaccion();
                $transaccion->idusuarioori = $session->idvendedor;
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
                $pago->idvendedor = $session->idvendedor;
                $pago->saldo = $venta->valortotal - $venta->valorventa;
                $pago->canal = 'Fisico';
                $pago->descripcion = $descripcion;
                $pago->tipo = 'Pago';
                $pago->soporte = $request->comprobante;
                $pago->idtransaccion = $transaccion->id;
                $pago->idpuntoventa = $session->idpuntoventa;
                $pago->idcaja = $request->idcaja;
                $pago->save();

                $data = [
                    'vendedor' => $session->vendedor->full_name,
                    'usuario' => $user->username,
                    'rifa' => $session->rifa->titulo,
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

                // Envío de mensajes de texto
                foreach ($boletas as $boleta) {
                    $cliente = Cliente::where('id', $boleta->idcliente)->first();

                    $to = "57".$cliente->movil;

                    $saldo = $boleta->valortotal - $boleta->valor;
                    $saldotxt = '';

                    if ($saldo > 0) {
                        $saldotxt = "Tu saldo pendiente es $saldo.";
                    }
                    $message = "Los Tres Ases te da la bienvenida y agradece tu fidelidad, el gran bono millonario premio mayor $boleta->numero promocional $boleta->promocional ha sido registrado con exito. $saldotxt SUERTE";

                    $this->sendSMS($to, $message);
                    if ($saldo == 0) {
                        $message = "Conserva este mensaje de paz y salvo valido para reclamar el premio mayor: Apto Robles, Camioneta mazda y Tour resolucion EDSA N 999 premio mayor $boleta->numero y promocional $boleta->promocional. Sorteo miercoles 21 de diciembre de 2022 con el premio mayor de la loteria de manizales";

                        $this->sendSMS($to, $message);
                    }
                }

                $r = new Request();
                $r->idsesion = $session->id;
                $r->isSale = true;
                $this->finishSession($r);

                return ['url' => url('/storage/pdf/').'/'.$filename];
            }
        } catch (\Exception $e) {
            // An error occured; cancel the transaction...
            DB::rollback();
            dd($e);

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
                $concomision = Confcomision::join('vendedors as t1', 'confcomisiones.idvendedor', '=', 't1.idempresa')
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
            asort($salida);
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
dd($e);
            return back()->withErrors(['error' => ['No se pudo registrar la venta, por favor validar los parámetros ingresados']]);
            // and throw the error again.
            //throw $e;
        }

    }

    public function sendSmsSales(Request $request) {
        $id = $request->id;

        $detalle = Detalleventa::where('id', $id)
                              ->with('cliente')
                              ->with('boleta')
                              ->first();
        $to = "57".$detalle->cliente->movil;//"573155665528";

        $saldo = $detalle->boleta->saldo;
        $saldotxt = '';

        if ($saldo > 0) {
            $saldotxt = "Tu saldo pendiente es $saldo.";
        }
        $message = "Los Tres Ases te da la bienvenida y agradece tu fidelidad, el gran bono millonario premio mayor ".$detalle->boleta->numero." promocional ".$detalle->boleta->promocional." ha sido registrado con exito. $saldotxt SUERTE";

        $this->sendSMS($to, $message);
        if ($saldo == 0) {
            $message = "Conserva este mensaje de paz y salvo valido para reclamar el premio mayor: Apto Plaza Robles, Camioneta mazda y Tour resolucion EDSA N 999 premio mayor ".$detalle->boleta->numero." y promocional ".$detalle->boleta->promocional.". Sorteo miercoles 21 de diciembre de 2022 con el premio mayor de la loteria de manizales";

            $this->sendSMS($to, $message);
        }
    }

    public function anularVenta(Request $request) {
        $id = $request->id;
        $idcaja = $request->idcaja;
        $mytime= Carbon::now('America/Bogota');

        try {
            DB::beginTransaction();
            $detalle = Detalleventa::where('id', $id)->first();
            $boleta = Boleta::where('id', $detalle->idboleta)->first();
            $venta = Venta::where('id', $detalle->idventa)->first();

            // Se realiza venta negativa par anular la anterior
            $ventanew = new Venta();
            $ventanew->valorventa = -$detalle->valor;
            $ventanew->valortotal = -$detalle->valortotal;
            $ventanew->comision = -$detalle->comision;
            $ventanew->cantidad = 1;
            $ventanew->idvendedor = $venta->idvendedor;
            $ventanew->idpuntoventa = $request->idpuntoventa;
            $ventanew->fechaventa = $mytime->format('Y-m-d');
            $ventanew->estado = 6;
            $ventanew->impuesto = 0;
            $ventanew->save();

            $detallenew = new Detalleventa();
            $detallenew->idventa = $ventanew->id;
            $detallenew->idboleta = $detalle->idboleta;
            $detallenew->idrifa = $detalle->idrifa;
            $detallenew->idcliente = $detalle->idcliente;
            $detallenew->valor = -$detalle->valor;
            $detallenew->impuesto = -$detalle->impuesto;
            $detallenew->comision = -$detalle->comision;
            $detallenew->valortotal = -$detalle->valortotal;
            $detallenew->numero = $detalle->numero;
            $detallenew->cantidad = $detalle->cantidad;
            $detallenew->estado = 6;
            $detallenew->save();

            $boleta->pago = $boleta->pago + $detallenew->valor;
            $boleta->saldo = $boleta->valor - $boleta->pago;

            if ($boleta->pago == 0) {
                $boleta->idcliente = null;
                $boleta->idvendedor = null;
                $boleta->estado = 1;
            } else {
                $boleta->estado = 4;
            }
            $boleta->save();
            $concomision = $this->getSalesComision($ventanew->idvendedor);

            $comisionnew = new Comision();
            $comisionnew->idventa = $ventanew->id;
            $comisionnew->idconfiguracion = $concomision->id;
            $comisionnew->valorventa = $ventanew->valorventa;
            $comisionnew->comisionmayorista = $ventanew->valorventa * ($concomision->comisionmayorista/100);
            $comisionnew->comisiondistribuidor = $ventanew->valorventa * ($concomision->comisiondistribuidor/100);
            $comisionnew->comisionvendedor = $ventanew->valorventa * ($concomision->comisionvendedor/100);
            $comisionnew->estado = 6;
            $comisionnew->save();

            $concepto = 5;
            $descripcion = 'Anulación Pago en efectivo';
            $signo = self::credito;
            $impuesto = 0;

            $transaccion = new Transaccion();
            $transaccion->idusuarioori = $ventanew->idvendedor;
            $transaccion->idusuariodest = Auth::user()->id;
            $transaccion->idconcepto = $concepto;
            $transaccion->origen = 'Fisico';
            $transaccion->destino = 'Fisico';
            $transaccion->signo = $signo;
            $transaccion->valor = $ventanew->valorventa;
            $transaccion->impuesto = $impuesto;
            $transaccion->descripcion = $descripcion;
            $transaccion->soporte = $request->comprobante;
            $transaccion->mes = $mytime->month;
            $transaccion->ano = $mytime->year;
            $transaccion->save();

            $ventanew->transaccion = $request->idcaja;
            $ventanew->save();

            $pago = new Pago();
            $pago->idventa = $ventanew->id;
            $pago->valortotal = $ventanew->valorventa;
            $pago->idcliente = null;
            $pago->idvendedor = $ventanew->idvendedor;
            $pago->saldo = $ventanew->valortotal - $ventanew->valorventa;
            $pago->canal = 'Fisico';
            $pago->descripcion = $descripcion;
            $pago->tipo = 'Devolucion Pago';
            $pago->soporte = $request->comprobante;
            $pago->idtransaccion = $transaccion->id;
            $pago->idpuntoventa = $ventanew->idpuntoventa;
            $pago->idcaja = $request->idcaja;
            $pago->save();

            $recibo = new Recibo();
            $recibo->nombre = 'Recibo anulacion venta';
            $recibo->url = 'Recibo anulacion venta';
            $recibo->idusuario = Auth::user()->id;
            $recibo->iduserdestino = $ventanew->idvendedor;
            $recibo->save();

            $vendedor = Vendedor::where('id', $ventanew->idvendedor)->first();
            $rifa = Rifa::where('id', $detallenew->idrifa)->first();
            /*
            $salida = [[
                            'numero' => $boleta->numero,
                            'promocional' => $boleta->promocional,
                            'valorpagado' => $detallenew->valor,
                            'comision' => $detallenew->comision
                        ]];
            */
            $object = new \stdClass();
            $object->numero = $boleta->numero;
            $object->promocional = $boleta->promocional;
            $object->valorpagado = $detallenew->valor;
            $object->comision = $detallenew->comision;
            $salida = [];
            $salida = [$object];

            // se imprime pdf
            $data = [
                'vendedor' => $vendedor->full_name,
                'usuario' => Auth::user()->username,
                'rifa' => $rifa->titulo,
                'fecha' => $recibo->created_at,
                'reservas' => $salida,
                'recibo'  => $recibo->id,
                'comisionvendedor' => "$" . number_format($detallenew->comision, 0, ".", ","),
                'valortotal' => "$" . number_format($ventanew->valorventa, 0, ".", ","),
                'valorentregar' => "$" . number_format($ventanew->valorventa - $detallenew->comision, 0, ".", ","),
                'cantidad' => 1
            ];

            $filename = 'reciboAnulacionVenta_'.$data['recibo'].'.pdf';
            $recibo->url = $filename;
            $recibo->save();
            $pdf = app('dompdf.wrapper');
            $pdf->getDomPDF()->set_option("enable_php", true);
            $pdf->loadView('pdf.reportpdfAnulacionVenta', $data);

            $output = $pdf->output();
            file_put_contents(public_path('storage').'/pdf/'.$filename, $output, FILE_APPEND);
            $ventanew->urlrecibo = url('/storage/pdf/').'/'.$filename;
            $ventanew->save();

            DB::commit();
            return ['status' => true, 'url' => url('/storage/pdf/').'/'.$filename];
        } catch (\Exception $e) {
            DB::rollback();
            return ['status' => $e->getMessage()];
            //return back()->withErrors(['error' => ['No se pudo registrar la venta, por favor validar los parámetros ingresados']]);
        }
    }

    public function initSession(Request $request) {
        $time = config('session.max_time_sales');

        $idusuario = Auth::user();

        if ($idusuario->idrol == 5) {
            $idvendedor = $idusuario->id;
        } else {
            $idvendedor = null;
        }

        $detallesession = null;

        $session = Sesionventa::where('idusuario', $idusuario->id)
                                ->where('idpuntoventa', $request->idpuntoventa)
                                ->where('estado', 1)
                                ->with('vendedor')
                                ->with('rifa')
                                ->first();
        if($session) {
            if ($session->created_at->diffInSeconds() > $time) {
                $boletas = Boleta::join('detallesesion', 'boletas.id', '=', 'detallesesion.idboleta')
                    ->where('detallesesion.idsesionventa', $session->id)
                    ->select('boletas.*')
                    ->get();
                $detalle = Detallesesion::where('idsesionventa', $session->id)->delete();

                foreach ($boletas as $dato) {
                    $dato->estado = $dato->estado_ant;
                    $dato->save();
                }
                $session->delete();
                $session = new Sesionventa();
                $session->idusuario = $idusuario->id;
                $session->idrifa = $request->idrifa;
                $session->idvendedor = $idvendedor;
                $session->idpuntoventa = $request->idpuntoventa;
                $session->estado = 1;
                $session->save();
            } else {
                $detallesession = Detallesesion::join('boletas', 'detallesesion.idboleta', 'boletas.id')
                                               ->leftJoin('clientes', 'detallesesion.idcliente', 'clientes.id')
                                               ->where('detallesesion.idsesionventa', $session->id)
                                               ->select('detallesesion.*', 'boletas.pago', 'boletas.saldo', 'boletas.numero', 'boletas.promocional', 'boletas.valor as valortotal', DB::raw('CONCAT(clientes.nombre, " ", clientes.apellido) AS full_name'))
                                               ->get();
                $time = $time - $session->created_at->diffInSeconds();
            }
        } else {
            $session = new Sesionventa();
            $session->idusuario = $idusuario->id;
            $session->idrifa = $request->idrifa;
            $session->idvendedor = $idvendedor;
            $session->idpuntoventa = $request->idpuntoventa;
            $session->estado = 1;
            $session->save();
        }

        return ['session' => $session, 'time' => $time, 'detallesession' => $detallesession ];
    }

    public function updateSession(Request $request) {
        $idsesion = $request->idsesion;

        $session = Sesionventa::where('id', $idsesion)
                                ->first();
        $session->idvendedor = $request->idvendedor;
        $session->idrifa = $request->idrifa;
        $session->save();

        return 1;
    }

    public function updDetailSession(Request $request) {

        $boletaupd = json_decode($request->boleta);
        $idsesion  = $request->idsesion;

        if ($request->type == 'add') {
            $detalle = new Detallesesion();
            $detalle->idsesionventa = $idsesion;
            $detalle->idboleta = $boletaupd->id;
            $detalle->valor = $boletaupd->saldo;
            $detalle->idcliente = $boletaupd->idcliente;
            $detalle->save();

            $boleta = Boleta::where('id', $boletaupd->id)->first();
            $boleta->estado_ant = $boleta->estado;
            $boleta->estado = 5;
            $boleta->save();

            \Cart::session(Auth::user()->id);
            \Cart::add(array(
                'id' => $idsesion, // inique row ID
                'name' => $boleta->numero,
                'price' => $boleta->valor,
                'quantity' => 1,
                'attributes' => array(
                    'url' => $request->url,
                    'serie' => '',
                    'descripcion' => '',
                    'idrifa' => $boleta->idrifa,
                    'numero' => $boleta->numero,
                    'codigo' => $boleta->id
                ),
                'associatedModel' => Boleta::class
            ));
        }

        if ($request->type == 'del') {
            $detalle = Detallesesion::join('boletas', 'boletas.id', '=', 'detallesesion.idboleta')
                                     ->where('detallesesion.idsesionventa', $idsesion)
                                     ->where('boletas.numero', $boletaupd->numero)
                                     ->delete();

            $boleta = Boleta::where('numero', $boletaupd->numero)->first();
            $boleta->estado = $boleta->estado_ant;
            $boleta->save();
        }

        if ($request->type == 'upd') {
            $detalle = Detallesesion::join('boletas', 'boletas.id', '=', 'detallesesion.idboleta')
                                    ->where('detallesesion.idsesionventa', $idsesion)
                                    ->where('boletas.numero', $boletaupd->numero)
                                    ->select('detallesesion.*')
                                    ->first();
            $detalle->valor = $boletaupd->valorpagar;
            $detalle->idcliente = $boletaupd->idcliente;
            $detalle->save();
        }
        return 1;
    }

    public function finishSession(Request $request) {

        try {
            DB::beginTransaction();

            $idsesion = $request->idsesion;
            $session = Sesionventa::where('id', $idsesion)->delete();

            $boletas = Boleta::join('detallesesion', 'boletas.id', '=', 'detallesesion.idboleta')
                            ->where('detallesesion.idsesionventa', $idsesion)
                            ->select('boletas.*')
                            ->get();
            $detalle = Detallesesion::where('idsesionventa', $idsesion)->delete();

            if (!$request->isSale) {
                foreach ($boletas as $dato) {
                    $dato->estado = $dato->estado_ant;
                    $dato->save();
                }
            }

            \Cart::session(Auth::user()->id);
            \Cart::remove($idsesion);

           DB::commit();
        } catch (Throwable $e){
            DB::rollBack();
        }
        return 1;
    }

    private function sendSMS($to, $message) {
        $to = '573155665528';
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic QWRhbW1Tb2x1Y2lvbmVzX0JfMVdFOjZpW3pMRVEkTWI=',
        ])->post("https://api-sms.masivapp.com/send-message", [
            "to" => $to,
            "text" => $message,
            "customdata" => "CUS_ID_0125",
            "isPremium" => false,
            "isFlash" => false,
            "isLongmessage" => true,
            "isRandomRoute" => false
        ]);

        return $response;
    }



}
