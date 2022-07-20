<?php

namespace App\Http\Controllers;

use App\Models\Boleta;
use App\Models\Detalleventa;
use App\Models\Loteria;
use App\Models\Imagen;
use App\Models\NumeroReservado;
use App\Models\Promoboleta;
use App\Models\Recibo;
use App\Models\Rifa;
use App\Models\User;
use App\Models\Venta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;


class NumeroreservadoController extends Controller
{
    const canPorPagina = 15;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $token = csrf_token();
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
                ->where('boletas.estado', '2')
                ->paginate(self::canPorPagina);
        } else {
            $boletas = Boleta::orderBy($sortBy, $sortOrder)
                ->with('rifa')
                ->with('vendedor')
                ->with('cliente')
                ->where('boletas.estado', '2');

            if(!is_null($filtros->rifa) && $filtros->rifa <> '' && $filtros->rifa <> 0) {
                $boletas = $boletas->where('boletas.idrifa', $filtros->rifa);
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
                $boletas = $boletas->join('users as t1', 'boletas.idcliente', '=', 't1.id')
                    ->where('t1.nombre', 'like', '%'.$filtros->cliente.'%')
                    ->orWhere('t1.apellido', 'like', '%'.$filtros->cliente.'%');
            }
            if(!is_null($filtros->idvendedor) && $filtros->idvendedor?$filtros->idvendedor:0 <> 0) {
                if ($filtros->idvendedor->id <> '' && $filtros->idvendedor->id <> 0) {
                    $boletas = $boletas->where('boletas.idvendedor', $filtros->idvendedor->id);
                }
            }
            $boletas = $boletas->select('boletas.*')->paginate(self::canPorPagina);
        }

        if ($request->has('ispage') && $request->ispage){
            return ['datos' => $boletas];
        } else {
            return Inertia::render('Rifas/Numerosreservados', ['datos' => $boletas, 'estado' => $request->estado, '_token' => $token]);
        }
    }

    public function buscar(Request $request)
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
            $numerosreservados = NumeroReservado::orderBy($sortBy, $sortOrder)
                ->with('rifa')
                ->with('vendedor')
                ->with('cliente')
                ->paginate(self::canPorPagina);
        } else {
            $numerosreservados = NumeroReservado::orderBy($sortBy, $sortOrder)
                ->with('rifa')
                ->with('vendedor')
                ->with('cliente')
                ->where('rifa.nombre', 'like', '%'. $buscar . '%')
                ->orWhere('numero', 'like', '%'. $buscar . '%')
                ->orWhereBetween($buscar, ['rangoinicial', 'rangofinal'])
                ->paginate(self::canPorPagina);
        }

        if ($request->has('ispage') && $request->ispage){
            return ['numerosreservados' => $numerosreservados];
        } else {
            return Inertia::render('Rifas/Numerosreservados', ['numerosreservados' => $numerosreservados]);
        }
    }

    public function valBoletaDisponible(Request $request) {
        $idrifa = $request->rifa;
        $numero = $request->numero;
        $estado = false;

        $boleta = Boleta::where('idrifa', $idrifa)
            ->where('estado', '=', 1)
            ->where('numero', $numero)
            ->first();

        if (!is_null($boleta)) {
            $estado = true;
        } else {
            $estado = false;
        }
        return ['boleta' => $boleta, 'isocupado' => $estado];
    }

    public function getBoletaOcupadaVenta(Request $request) {
        $idrifa = $request->rifa;
        $numero = $request->numero;
        $idvendedor = $request->idvendedor;
        $idcliente = $request->idcliente;
        $estado = false;

        $boleta = Boleta::where('idrifa', $idrifa)
            ->where('estado', '=', 1)
            ->where('numero', $numero)
            ->first();

        if (!is_null($boleta)) {
            $estado = true;
        } else {
            $boleta = Boleta::where('idrifa', $idrifa)
                ->with('cliente')
                ->where('numero', $numero)
                ->where('idvendedor', $idvendedor)
                ->whereIn('estado', [2,4])
                ->first();
            if (!is_null($boleta)) {
                $estado = true;
            } else {
                $estado = false;
            }
        }
        return ['boleta' => $boleta, 'isocupado' => $estado];
    }

    public function getBoletaVendida(Request $request) {
        $idrifa = $request->rifa;
        $numero = $request->numero;
        $idvendedor = $request->idvendedor;
        $idcliente = $request->idcliente;
        $estado = false;

        $boleta = Boleta::where('idrifa', $idrifa)
            ->with('cliente')
            ->whereIn('estado', [3,4])
            ->where('idvendedor', $request->idvendedor)
            ->where('numero', $numero)
            ->first();

        if (!is_null($boleta)) {
            $estado = true;
        } else {
            $estado = false;
        }
        return ['boleta' => $boleta, 'isocupado' => $estado];
    }

    public function valBoletaOcupada(Request $request) {
        $idrifa = $request->rifa;
        $numero = $request->numero;
        $idvendedor = $request->idvendedor;
        $estado = false;

        $boleta = Boleta::where('idrifa', $idrifa)
            ->where('estado', '=', 2)
            ->where('numero', $numero)
            ->where('idvendedor', $idvendedor)
            ->first();

        if (!is_null($boleta)) {
            $estado = true;
        } else {
            $estado = false;
        }
        return ['boleta' => $boleta, 'isocupado' => $estado];

    }

    public function eliminarReserva(Request $request) {
        $idrifa = $request->rifa;
        $numero = $request->numero;
        $estado = false;

        $boleta = Boleta::where('idrifa', $idrifa)
            ->where('estado', '=', 2)
            ->where('numero', $numero)
            ->first();

        if (!is_null($boleta)) {
            $estado = true;
            $boleta->estado = 1;
            $boleta->idvendedor = null;
            $boleta->save();
        } else {
            $estado = false;
        }
        return ['boleta' => $boleta, 'isocupado' => $estado];

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // if (!$request->ajax()) return redirect('/');
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
        $mytime= Carbon::now('America/Bogota');
        $isBussy = $this->validarReserva(
                        $request->isIndividual,
                        $request->numero,
                        $request->idrifa['id'],
                        $request->rangoinicial,
                        $request->rangofinal
        );

        if (!$isBussy) {
            return redirect()->back()
                ->withInput()
                ->withErrors([
                    'numero' => 'El número o rango ya se encuentra en uso'
                ]);

        } else {
            try {
                DB::beginTransaction();
                $reserva = new NumeroReservado();
                $reserva->idrifa = $request->idrifa['id'];
                $reserva->numero = $request->numero;
                $reserva->rangoinicial = $request->rangoinicial;
                $reserva->rangofinal = $request->rangofinal;
                $reserva->idvendedor = $request->idvendedor['id'];
                $reserva->idcliente = Auth::user()->id;
                $reserva->fecha = $mytime->toDateString();
                $reserva->save();

                DB::commit();
                $mensaje = 'La reserva se ha creado exitosamente';
            } catch (Throwable $e){
                DB::rollBack();
                $mensaje = 'Se ha presentado un error creando la reserva';
            }

        }
        return redirect()->back()
            ->with('message', $mensaje);
    }

    protected function validarReserva($isIndividual, $numero, $idrifa, $rangoinicial, $rangofinal) {
        if ($isIndividual == 1){
            $rifa = NumeroReservado::where('idrifa', '=', $idrifa)
                                    ->where(function($query) use ($numero){
                                        $query->where('numero', '=', $numero)
                                              ->orWhere(function($query) use ($numero) {
                                                  $query->where('rangofinal', '>=', $numero)
                                                        ->where('rangoinicial', '<=', $numero);
                                              });
                                    })
                                    ->get();
            if ($rifa->isEmpty()) {
                return true;
            } else {
                return false;
            }
        } else {
            $rifa = NumeroReservado::where('idrifa', '=', $idrifa)
                                    ->where(function($query) use ($rangoinicial, $rangofinal){
                                        $query->where('numero', '>=', $rangoinicial)
                                              ->where('numero', '<=', $rangofinal)
                                              ->orWhere(function($query) use ($rangoinicial, $rangofinal) {
                                                  $query->whereBetween('rangoinicial', [$rangoinicial, $rangofinal])
                                                        ->orwherebetween('rangofinal', [$rangoinicial, $rangofinal])
                                                         ->orWhere(function($query) use ($rangoinicial, $rangofinal) {
                                                              $query->where('rangoinicial', '<=', $rangoinicial)
                                                                      ->Where('rangofinal', '>=', $rangofinal);
                                                          });
                                              });
                                    })
                                    ->get();
            if ($rifa->isEmpty()) {
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rifa  $Rifa
     * @return \Illuminate\Http\Response
     */
    public function show(Rifa $Rifa)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rifa  $Rifa
     * @return \Illuminate\Http\Response
     */
    public function edit(Rifa $Rifa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rifa  $Rifa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $mensaje = '';

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
                'idterminos.gt' => 'Seleccione un registro',

            ])->validate();

        if ($request->has('id')) {
            Rifa::find($request->input('id'))
                ->update($request->all());
            return redirect()->back()
                ->with('message', 'La rifa ha sido actualizada');
        } else {
            return redirect()->back()
                ->with('message', 'No se pudo actualizar la rifa');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rifa  $Rifa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $mensaje = '';

        if ($request->has('id')) {
            Rifa::find($request->id)
                ->update(['estado' => !$request->estado]);
            return redirect()->back()
                ->with('message', 'El procero ha terminado correctamento');
        }

        return redirect()->back()
            ->with('message', $mensaje);
    }

    public function reportpdfAsignacion(Request $request)
    {
        try {
            // Begin a transaction
            DB::beginTransaction();
            $user = Auth::user();

            foreach ($request->reservas as $reserva){
                $reg = json_decode($reserva);
                $salida[] = $reg;
                $boleta = Boleta::where('idrifa', $request->idrifa)
                    ->where('estado', '=', 1)
                    ->where('numero', $reg->numero)
                    ->first();
                $boleta->estado = 2;
                $boleta->idvendedor = $request->iduserdestino;
                $boleta->save();
            }
            asort($salida);
            $recibo = new Recibo();
            $recibo->nombre = 'Recibo asignacion';
            $recibo->url = 'Recibo asignacion';
            $recibo->idusuario = Auth::user()->id;
            $recibo->iduserdestino = $request->iduserdestino;
            $recibo->save();

            $data = [
                'vendedor' => $request->vendedor,
                'usuario' => $user->username,
                'rifa' => $request->rifa,
                'fecha' => $recibo->created_at,
                'reservas' => $salida,
                'recibo'  => $recibo->id,
                'cantidad' => sizeof($salida)
            ];

            $filename = 'reciboAsignacion_'.$data['recibo'].'.pdf';
            $recibo->url = $filename;
            $recibo->save();
            $pdf = app('dompdf.wrapper');
            $pdf->getDomPDF()->set_option("enable_php", true);
            $pdf->loadView('pdf.reportpdfAsignacion', $data);

            $output = $pdf->output();
            file_put_contents(public_path('storage').'/pdf/'.$filename, $output, FILE_APPEND);
            DB::commit();

            return ['url' => url('/storage/pdf/').'/'.$filename];

        } catch (\Exception $e) {
            // An error occured; cancel the transaction...
            DB::rollback();

            return back()->withErrors(['error' => ['No se pudo reservar el número']]);
            //throw $e;
        }
    }

    public function reportpdfDesasignacion(Request $request)
    {
        try {
            DB::beginTransaction();
            $user = Auth::user();

            foreach ($request->reservas as $reserva){
                $reg = json_decode($reserva);
                $salida[] = $reg;
                $boleta = Boleta::where('idrifa', $request->idrifa)
                    ->where('estado', '=', 2)
                    ->where('numero', $reg->numero)
                    ->first();
                $boleta->estado = 1;
                $boleta->idvendedor = null;
                $boleta->save();
            }
            asort($salida);
            $recibo = new Recibo();
            $recibo->nombre = 'Recibo desasignacion';
            $recibo->url = 'Recibo desasignacion';
            $recibo->idusuario = Auth::user()->id;
            $recibo->iduserdestino = $request->iduserdestino;
            $recibo->save();

            $data = [
                'vendedor' => $request->vendedor,
                'usuario' => $user->username,
                'rifa' => $request->rifa,
                'fecha' => $recibo->created_at,
                'reservas' => $salida,
                'recibo'  => $recibo->id,
                'cantidad' => sizeof($salida)
            ];

            $filename = 'reciboDesasignacion_'.$data['recibo'].'.pdf';
            $recibo->url = $filename;
            $recibo->save();
            $pdf = app('dompdf.wrapper');
            $pdf->getDomPDF()->set_option("enable_php", true);
            $pdf->loadView('pdf.reportpdfDesasignacion', $data);

            $output = $pdf->output();
            file_put_contents(public_path('storage').'/pdf/'.$filename, $output, FILE_APPEND);
            DB::commit();

            return ['url' => url('/storage/pdf/').'/'.$filename];
        } catch (\Exception $e) {
            // An error occured; cancel the transaction...
            DB::rollback();

            return back()->withErrors(['error' => ['No se pudo reservar el número']]);
                //throw $e;
        }
    }

    public function reportpdfCliente(Request $request)
    {
        $detalleventa = Detalleventa::where('id', $request->iddetalleventa)
                                     ->with('cliente')
                                     ->with('boleta')
                                     ->with('boleta.vendedor')
                                     ->with('rifa')
                                     ->first();
        $recibo = new Recibo();
        $recibo->nombre = 'Recibo cliente';
        $recibo->url = 'Recibo cliente';
        $recibo->idusuario = Auth::user()->id;
        $recibo->iduserdestino = $detalleventa->cliente->id;
        $recibo->save();

        $data = [
            'vendedor' => $detalleventa->boleta->vendedor->full_name,
            'cliente' => $detalleventa->cliente->full_name,
            'usuario' => Auth::user()->username,
            'rifa' => $detalleventa->rifa->titulo,
            'fecha' => $detalleventa->created_at,
            'numero' => $detalleventa->boleta->numero,
            'promocional' => $detalleventa->boleta->promocional,
            'total' => "$" . number_format($detalleventa->boleta->valor, 0, ".", ","),
            'pagado' => "$" . number_format($detalleventa->boleta->pago, 0, ".", ","),
            'saldo' => "$" . number_format($detalleventa->boleta->saldo, 0, ".", ","),
            'recibo'  => $recibo->id
        ];

        $filename = 'reciboAsignacion_'.$data['recibo'].'.pdf';
        $recibo->url = $filename;
        $recibo->save();
        $pdf = app('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->loadView('pdf.reportpdfVentaCliente', $data);

        return $pdf->download($filename);

        $output = $pdf->output();
        //file_put_contents(public_path('storage').'/pdf/'.$filename, $output, FILE_APPEND);

        //return ['url' => url('/storage/pdf/').'/'.$filename];
    }
}
