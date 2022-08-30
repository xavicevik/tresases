<?php

namespace App\Http\Controllers;

use App\Jobs\CrearBoletasJob;
use App\Models\Boleta;
use App\Models\Detalleventa;
use App\Models\Loteria;
use App\Models\Imagen;
use App\Models\Promocional;
use App\Models\Rifa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;;

use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class RifaController extends Controller
{
    const canPorPagina = 20;
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
            $rifas = Rifa::orderBy($sortBy, $sortOrder)
                ->with('pais')
                ->with('departamento')
                ->with('ciudad')
                ->with('loteria')
                ->with('terminosycondiciones')
                ->with('tiposerie')
                ->with('promocionales')
                ->paginate(self::canPorPagina);
        } else {
            $rifas = Rifa::orderBy($sortBy, $sortOrder)
                ->with('pais')
                ->with('departamento')
                ->with('ciudad')
                ->with('loteria')
                ->with('terminosycondiciones')
                ->with('tiposerie')
                ->with('promocionales')
                ->where('nombre', 'like', '%'. $buscar . '%')
                ->orWhere('nombre_tecnico', 'like', '%'. $buscar . '%')
                ->paginate(self::canPorPagina);
        }

        if ($request->has('ispage') && $request->ispage){
            return ['rifas' => $rifas];
        } else {
            return Inertia::render('Rifas/Index', ['rifas' => $rifas]);
        }
    }

    public function indexboletas(Request $request)
    {
        //DB::connection()->enableQueryLog();
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
                ->paginate(self::canPorPagina);
        } else {
            $boletas = Boleta::orderBy($sortBy, $sortOrder)
                ->with('rifa')
                ->with('vendedor')
                ->with('cliente');

            if(!is_null($filtros->rifa) && $filtros->rifa <> '' && $filtros->rifa <> 0) {
                $boletas = $boletas->where('boletas.idrifa', $filtros->rifa);
            }

            if(!is_null($filtros->vendedor) && $filtros->vendedor <> '' && $filtros->vendedor <> 0) {
                $boletas = $boletas->where('boletas.idvendedor', $filtros->vendedor);
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
                $boletas = $boletas->join('clientes as t1', 'boletas.idcliente', '=', 't1.id')
                    ->where('t1.nombre', 'like', '%'.$filtros->cliente.'%')
                    ->orWhere('t1.apellido', 'like', '%'.$filtros->cliente.'%')
                    ->orWhere('t1.documento', 'like', '%'.$filtros->cliente.'%');
            }

            $boletas = $boletas->select('boletas.*')->paginate(self::canPorPagina);
        }
        //$queries = DB::getQueryLog();

        if ($request->has('ispage') && $request->ispage){
            return ['datos' => $boletas];
        } else {
            return Inertia::render('Rifas/Indexboletas', ['datos' => $boletas, 'estado' => $request->estado]);
        }
    }

    public function getHistorialBoleta(Request $request)
    {
        $boletas = Detalleventa::where('idboleta', $request->id)
                                 ->paginate(self::canPorPagina);
        return ['data' => $boletas];
    }

    public function getRifasActivas(Request $request)
    {
        $buscar = $request->buscar;
        $filtro = $request->filtro;
        $paginate = $request->paginate;
        if (isset($request->page) and $request->page > 0){
            $paginate = true;
        }

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

        $mytime= Carbon::now('America/Bogota');

        if ($paginate) {
            if ($buscar == ''){
                $rifas = Rifa::orderBy($sortBy, $sortOrder)
                    ->with('pais')
                    ->with('departamento')
                    ->with('ciudad')
                    ->with('loteria')
                    ->with('tiposerie')
                    ->with('promocionales')
                    ->where('estado', '=', '1')
                    ->where('fechafin', '>', $mytime->toDateString())
                    ->paginate(self::canPorPagina);
            } else {
                $rifas = Rifa::orderBy($sortBy, $sortOrder)
                        ->with('pais')
                        ->with('departamento')
                        ->with('ciudad')
                        ->with('loteria')
                        ->with('tiposerie')
                        ->with('promocionales')
                        ->where('estado', '=', '1')
                        ->where('fechafin', '>', $mytime->toDateString())
                        ->where($filtro, 'like', '%'. $buscar . '%')
                        ->paginate(self::canPorPagina);
            }
        } else {
            if ($buscar == ''){
                $rifas = Rifa::orderBy($sortBy, $sortOrder)
                    ->with('pais')
                    ->with('departamento')
                    ->with('ciudad')
                    ->with('loteria')
                    ->with('tiposerie')
                    ->with('promocionales')
                    ->where('estado', '=', '1')
                    ->where('fechafin', '>', $mytime->toDateString())
                    ->get();
            } else {
                $rifas = Rifa::orderBy($sortBy, $sortOrder)
                        ->with('pais')
                        ->with('departamento')
                        ->with('ciudad')
                        ->with('loteria')
                        ->with('tiposerie')
                        ->with('promocionales')
                        ->where('estado', '=', '1')
                        ->where('fechafin', '>', $mytime->toDateString())
                        ->where($filtro, 'like', '%'. $buscar . '%')
                    >get();
            }
        }

        return ['rifas' => $rifas];
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
        $codigo = 0;
        $mensaje = null;
        $allowedfileExtension = ['pdf','jpg','png','docx'];
        $isUrl1 = true;


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


        try{
            DB::beginTransaction();

            $rifa = new Rifa();
            $rifa->titulo = $request->titulo;
            $rifa->resolucion = $request->resolucion;
            $rifa->estado = $request->estado;
            $rifa->nombre = $request->nombre;
            $rifa->descripcion = $request->descripcion;
            $rifa->nombre_tecnico = $request->nombre_tecnico;
            $rifa->resumen = $request->resumen;
            $rifa->url = $request->url;
            $rifa->idloteria = $request->idloteria;
            $rifa->idpais = $request->idpais;
            $rifa->iddepartamento = $request->iddepartamento;
            $rifa->idciudad = $request->idciudad;
            $rifa->cifras = $request->cifras;
            $rifa->precio = $request->precio;
            $rifa->fechainicio = $request->fechainicio;
            $rifa->fechafin = $request->fechafin;
            $rifa->promocional = $request->promocional;
            $rifa->publicar = $request->publicar;
            $rifa->fisica = $request->fisica;
            $rifa->principal = $request->principal;
            $rifa->urlimagen2 = $request->urlimagen2;
            $rifa->urlimagen1 = $request->urlimagen1;
            $rifa->idterminos = $request->idterminos;
            $rifa->idserie = $request->idserie;
            $rifa->serie = $request->serie;
            $rifa->serieoculta = $request->serieoculta;
            $rifa->idcreador = Auth::user()->id;
            $rifa->save();

            $promocionales = $request->promocionales;

            if (isset($promocionales) && sizeof($promocionales) > 0) {
                foreach($promocionales as $ep=>$det)
                {
                    $promocional = new Promocional();
                    $promocional->idrifa = $rifa->id;
                    $promocional->idloteria = $det['idloteria'];
                    $promocional->fecha = $det['fecha'];
                    $promocional->premio = $det['premio'];
                    $promocional->cifras = $rifa->cifras;
                    $promocional->save();
                }
            }

            if(isset($request->files)){
                $files = $request->files;

                foreach ($files as $index) {
                    foreach ($index as $file) {
                        $filename = $file->getClientOriginalName();
                        $extension = $file->getClientOriginalExtension();

                        $imagen = new Imagen();
                        $imagen->idorigen = $rifa->id;
                        $imagen->tabla = 'rifas';
                        $imagen->nombre = $filename;
                        $imagen->url = time(). '_' . $filename;
                        $imagen->extension = $extension;
                        $file->move(public_path('storage'), $imagen->url);
                        $imagen->save();
                        if ($isUrl1) {
                            $rifa->urlimagen1 = $imagen->url;
                            $isUrl1 = !$isUrl1;
                        } else {
                            $rifa->urlimagen2 = $imagen->url;
                        }
                        $rifa->save();
                    }
                }
            }

            //$this->crearBoleteria($rifa->id, $rifa->cifras, $rifa->serie);
            CrearBoletasJob::dispatch($rifa->id, $rifa->fisica, $rifa->cifras, $rifa->serie, $rifa->precio);

            DB::commit();

            $mensaje = 'La Rifa se ha creado exitosamente';
        } catch (Throwable $e){
            DB::rollBack();
            $codigo = -1;
            $mensaje = 'Se ha presentado un error creando la rifa';
        }

        return redirect()->back()
            ->with('message', $mensaje);
    }

    public static function crearBoleteria($idrifa, $isFisica, $cifras, $serie, $precio) {

        $cantboletas = pow(10, $cifras);

        for ($i = 0; $i < $cantboletas; $i++) {
            $boleta = new Boleta();
            $boleta->idrifa = $idrifa;
            $boleta->codigo = $idrifa . $i . rand(1000000000, 9999999999);
            $boleta->estado = 1;
            $boleta->serie = $serie;
            $boleta->valor = $precio;
            $boleta->saldo = $precio;
            $boleta->pago = 0;
            $boleta->numero = str_pad(strval($i), $cifras, "0", STR_PAD_LEFT);
            $boleta->save();
        }

        if ($isFisica) {
            $boletas = Boleta::where('estado', 1)
                             ->where('idrifa', $idrifa)
                             ->inRandomOrder()
                             ->get();
            $i = 0;
            foreach($boletas as $boleta) {
                $boleta->promocional = str_pad(strval($i), $cifras, "0", STR_PAD_LEFT);
                $boleta->save();
                $i++;
            }
        }

        return ['status' => 'Terminado'];
    }

    public function copy(Request $request)
    {
        try{
            DB::beginTransaction();

            $rifaold = Rifa::find($request->input('id'));
            $rifa = $rifaold->replicate();

            if ($request->isOculta) {
                $rifa->serieoculta = $request->serieoculta;
            } else {
                $rifa->idserie = $request->tiposeriedestino;
                $rifa->serie = $request->seriedestino;
            }
            $rifa->idcreador = Auth::user()->id;
            $rifa->save();

            $promocionales = Promocional::where('idrifa', $rifaold->id)
                                          ->get();

            if (isset($promocionales) && sizeof($promocionales) > 0) {
                foreach($promocionales as $ep=>$det)
                {
                    $promocional = $det->replicate();
                    $promocional->idrifa = $rifa->id;
                    $promocional->save();
                }
            }

            $imagenes = Imagen::where('idorigen', $rifaold->id)
                               ->get();

            if (isset($imagenes) && sizeof($imagenes) > 0) {
                foreach($imagenes as $ep=>$det)
                {
                    $imagen = $det->replicate();
                    $imagen->idorigen = $rifa->id;
                    $imagen->save();
                }
            }

            DB::commit();

            $mensaje = 'La Rifa se ha creado exitosamente';
        } catch (Throwable $e){
            DB::rollBack();
            $codigo = -1;
            $mensaje = 'Se ha presentado un error creando la rifa';
        }

        return redirect()->back()
            ->with('message', $mensaje);
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
