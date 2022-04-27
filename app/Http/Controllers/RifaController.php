<?php

namespace App\Http\Controllers;

use App\Models\Loteria;
use App\Models\Imagen;
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
            $rifas = Rifa::orderBy($sortBy, $sortOrder)
                ->with('pais')
                ->with('departamento')
                ->with('ciudad')
                ->with('loteria')
                ->with('terminosycondiciones')
                ->paginate(self::canPorPagina);
        } else {
            $rifas = Rifa::orderBy($sortBy, $sortOrder)
                ->with('pais')
                ->with('departamento')
                ->with('ciudad')
                ->with('loteria')
                ->with('terminosycondiciones')
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
            $rifa->destacada = $request->destacada;
            $rifa->principal = $request->principal;
            $rifa->urlimagen2 = $request->urlimagen2;
            $rifa->urlimagen1 = $request->urlimagen1;
            $rifa->idterminos = $request->idterminos;
            $rifa->idcreador = Auth::user()->id;
            $rifa->save();

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
