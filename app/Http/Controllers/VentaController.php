<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmailJob;
use App\Models\Boleta;
use App\Models\Detalleventa;
use App\Models\Loteria;
use App\Models\Imagen;
use App\Models\Promoboleta;
use App\Models\Promocional;
use App\Models\Rifa;
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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        //if (!$request->ajax()) return redirect('/');
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
            $ventas = Venta::orderBy($sortBy, $sortOrder)
                            ->with('puntoventa')
                            ->with('cliente')
                            ->with('vendedor')
                            ->paginate(self::canPorPagina);
        } else {
            $ventas = Venta::orderBy($sortBy, $sortOrder)
                            ->with('puntoventa')
                            ->with('cliente')
                            ->with('vendedor')
                            ->where('nombre', 'like', '%'. $buscar . '%')
                            ->orWhere('nombre_tecnico', 'like', '%'. $buscar . '%')
                            ->paginate(self::canPorPagina);
        }

        //$this->authorizeResource(User::class);

        if ($request->has('ispage') && $request->ispage){
            return ['data' => $ventas];
        } else {
            return Inertia::render('Ventas/Index', ['data' => $ventas]);
        }
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

            DB::commit();

            //return redirect()->route('enviar', ['notificacion' => $venta->id]);

            $data = Venta::where('id', $venta->id)
                ->with('detalles.boleta')
                ->with('detalles.rifa')
                ->with('cliente')
                ->with('vendedor')
                ->get();
            $venta = $data[0];

            $subject = "TresAses - Venta #".$request->idventa;
            $for = $venta['cliente']->correo;
            $url = $request->url;

            $data = array(
                'data'     => $venta,
                'subject'  => $subject
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

        $boleta = Boleta::ForceIndex('idx_rifa_num')
                          ->where('idrifa', $idrifa)
                          ->where('estado', '<>', 1)
                          ->where('numero', $numero)
                          ->first();

        $promoboleta = Promoboleta::where('idrifa', $idrifa)
                              ->where('estado', '<>', 1)
                              ->where('numero', $numero)
                              ->get();

        if (is_null($boleta)) {
            $estado = false;
            $boleta = Boleta::ForceIndex('idx_rifa_num')
                ->where('idrifa', $idrifa)
                ->where('estado', '=', 1)
                ->where('numero', $numero)
                ->first();
        }
        return ['boleta' => $boleta, 'promoboleta' => $promoboleta, 'isocupado' => $estado];

    }

    public function getRandBoletaLibre(Request $request) {
        $idrifa = $request->rifa;
        $tiporifa = $request->tiporifa;

        $bolval = Boleta::ForceIndex('idx_rifa_num')
                           ->where('estado', 1)
                           ->where('idrifa', $idrifa)
                           ->count();
        if ($bolval == 0) {
            $boleta = -99;
        } else {
            $boleta = Boleta::ForceIndex('idx_rifa_num')
                                ->where('estado', 1)
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


}
