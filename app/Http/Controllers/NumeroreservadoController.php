<?php

namespace App\Http\Controllers;

use App\Models\Loteria;
use App\Models\Imagen;
use App\Models\NumeroReservado;
use App\Models\Rifa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;;

use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;


class NumeroreservadoController extends Controller
{
    const canPorPagina = 3;
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
            $numerosreservados = NumeroReservado::orderBy($sortBy, $sortOrder)
                ->with('rifa')
                ->with('vendedor')
                ->with('cliente')
                ->paginate(self::canPorPagina);
        } else {
            $numerosreservados = NumeroReservado::orderBy($sortBy, $sortOrder)
                                ->join('rifas', 'numeros_reservados.idrifa', '=', 'rifas.id')
                                ->select('numeros_reservados.*')
                                ->with('rifa')
                                ->with('vendedor')
                                ->with('cliente')
                                ->where('rifas.titulo', 'like', '%'. $buscar . '%')
                                ->orWhere('numero', 'like', '%'. $buscar . '%')
                                ->orWhere(function($q) use ($buscar) {
                                    $q->where('rangoinicial', '<=', $buscar)
                                      ->where('rangofinal', '>=', $buscar);
                                })
                                ->paginate(self::canPorPagina);
        }
        if ($request->has('ispage') && $request->ispage){
            return ['numerosreservados' => $numerosreservados];
        } else {
            return Inertia::render('Rifas/Numerosreservados', ['numerosreservados' => $numerosreservados]);
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
}
