<?php

namespace App\Http\Controllers;

use App\Models\Imagen;
use App\Models\Puntoventa;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;;

use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class PuntoventaController extends Controller
{
    const canPorPagina = 5;

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
            $puntoventas = Puntoventa::orderBy($sortBy, $sortOrder)
                                      ->with('pais')
                                      ->with('departamento')
                                      ->with('ciudad')
                                      ->with('empresa')
                                      ->paginate(self::canPorPagina);
        } else {
            $puntoventas = Puntoventa::orderBy($sortBy, $sortOrder)
                                      ->with('pais')
                                      ->with('departamento')
                                      ->with('ciudad')
                                      ->with('empresa')
                                      ->where('nombre', 'like', '%'. $buscar . '%')
                                      ->orWhere('codigo', 'like', '%'. $buscar . '%')
                                      ->paginate(self::canPorPagina);
        }

        if ($request->has('ispage') && $request->ispage){
            return ['puntoventas' => $puntoventas];
        } else {
            return Inertia::render('Ventas/Puntoventas', ['puntoventas' => $puntoventas]);
        }
    }

    public function buscarPuntoventas(Request $request)
    {
        $buscar = $request->buscar;
        $sortBy = $request->sortBy;
        $sortOrder = $request->sortOrder;

        if ($buscar == ''){
            $puntoventas = Puntoventa::orderBy($sortBy, $sortOrder)
                ->with('pais')
                ->with('departamento')
                ->with('ciudad')
                ->with('empresa')
                ->paginate(self::canPorPagina);
        } else {
            $puntoventas = Puntoventa::orderBy($sortBy, $sortOrder)
                ->with('pais')
                ->with('departamento')
                ->with('ciudad')
                ->with('empresa')
                ->where('puntos_ventas.nombre', 'like', '%'. $buscar . '%')
                ->orWhere('puntos_ventas.codigo', 'like', '%'. $buscar . '%')
                ->paginate(self::canPorPagina);
        }

        return ['puntoventas' => $puntoventas];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $codigo = 0;
        $mensaje = null;

        try{
            DB::beginTransaction();

            $allowedfileExtension = ['pdf','jpg','png','docx'];

            $puntoventa = Puntoventa::create($request->all());

            if(isset($request->files)){
                $files = $request->files;

                foreach ($files as $index) {
                    foreach ($index as $file) {
                        $filename = $file->getClientOriginalName();
                        $extension = $file->getClientOriginalExtension();
                        $check = in_array($extension, $allowedfileExtension);

                        if($check) {
                            $imagen = new Imagen();
                            $imagen->idorigen = $puntoventa->id;
                            $imagen->tabla = 'puntos_ventas';
                            $imagen->nombre = $filename;
                            $imagen->url = time(). '_' . $filename;
                            $imagen->extension = $extension;
                            $file->move(public_path('storage'), $imagen->url);
                            $imagen->save();
                        } else {
                            $codigo = -1;
                            $mensaje = 'La extensión de al menos un archivo no es permitida';
                        }
                    }
                }
            }

            if ($codigo == -1) {
                DB::rollBack();
            } else {
                DB::commit();
            }

            $mensaje = 'El punto de venta se ha registrado exitosamente';
        } catch (Throwable $e){
            DB::rollBack();

            $codigo = -1;
            $mensaje = 'Se ha presentado un error ingresando el punto de venta';
        }

        return redirect()->back()
                         ->with('message', $mensaje);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Puntoventa  $puntoventa
     * @return \Illuminate\Http\Response
     */
    public function show(puntoventa $puntoventa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Puntoventa  $puntoventa
     * @return \Illuminate\Http\Response
     */
    public function edit(puntoventa $puntoventa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Puntoventa  $puntoventa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $mensaje = '';

        Validator::make($request->all(), [
            'nombre' => ['required'],
            'codigo' => ['required'],
        ])->validate();

        if ($request->has('id')) {
            Puntoventa::find($request->input('id'))
                ->update($request->all());
            return redirect()->back()
                ->with('message', 'El punto de venta ha sido actualizado');
        }

      //  return redirect()->back()
      //      ->with('message', $mensaje);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Puntoventa  $puntoventa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $mensaje = '';

        if ($request->has('id')) {
            Puntoventa::find($request->id)
                        ->update(['estado' => !$request->estado]);
            return redirect()->back()
                ->with('message', 'El procero ha terminado correctamento');
        }

        return redirect()->back()
            ->with('message', $mensaje);
    }
}
