<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Pais;
use App\Models\Rol;
use App\Models\Serie;
use App\Models\Terminosycondiciones;
use App\Models\TiposDocumento;
use Illuminate\Http\Request;

use Inertia\Inertia;

class MasterController extends Controller
{
    const canPorPagina = 5;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function rolesIndex(Request $request)
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
            $roles = Rol::orderBy($sortBy, $sortOrder)
                        ->paginate(self::canPorPagina);
        } else {
            $roles = Rol::orderBy($sortBy, $sortOrder)
                        ->where('nombre', 'like', '%'. $buscar . '%')
                        ->paginate(self::canPorPagina);
        }

        if ($request->has('ispage') && $request->ispage){
            return ['data' => $roles];
        } else {
            return Inertia::render('Masters/RolesIndex', ['data' => $roles]);
        }
    }

    public function paisesIndex(Request $request)
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
            $paises = Pais::orderBy($sortBy, $sortOrder)
                            ->with('departamentos.ciudades')
                            ->paginate(self::canPorPagina);
        } else {
            $paises = Pais::orderBy($sortBy, $sortOrder)
                            ->with('departamentos.ciudades')
                            ->where('nombre', 'like', '%'. $buscar . '%')
                            ->paginate(self::canPorPagina);
        }

        if ($request->has('ispage') && $request->ispage){
            return ['data' => $paises];
        } else {
            return Inertia::render('Masters/PaisesIndex', ['data' => $paises]);
        }
    }

    public function seriesIndex(Request $request)
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
            $series = Serie::orderBy($sortBy, $sortOrder)
                ->paginate(self::canPorPagina);
        } else {
            $series = Serie::orderBy($sortBy, $sortOrder)
                ->where('nombre', 'like', '%'. $buscar . '%')
                ->paginate(self::canPorPagina);
        }

        if ($request->has('ispage') && $request->ispage){
            return ['data' => $series];
        } else {
            return Inertia::render('Masters/SeriesIndex', ['data' => $series]);
        }
    }

    public function empresasIndex(Request $request)
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
            $empresas = Empresa::orderBy($sortBy, $sortOrder)
                ->with('tipodocumento')
                ->with('ciudad')
                ->with('tipoempresa')
                ->with('mayoristas')
                ->with('distribuidores')
                ->with('vendedores')
                ->with('padre')
                ->with('hijos.tipoempresa')
                ->with('hijos.ciudad')
                ->with('hijos.hijos.tipoempresa')
                ->with('hijos.hijos.ciudad')
                ->paginate(self::canPorPagina);
        } else {
            $empresas = Empresa::orderBy($sortBy, $sortOrder)
                ->where('nombre', 'like', '%'. $buscar . '%')
                ->with('tipodocumento')
                ->with('ciudad')
                ->with('tipoempresa')
                ->with('mayoristas')
                ->with('distribuidores')
                ->with('vendedores')
                ->with('padre')
                ->with('hijos.tipoempresa')
                ->with('hijos.ciudad')
                ->with('hijos.hijos.tipoempresa')
                ->with('hijos.hijos.ciudad')
                ->paginate(self::canPorPagina);
        }

        if ($request->has('ispage') && $request->ispage){
            return ['data' => $empresas];
        } else {
            return Inertia::render('Masters/EmpresasIndex', ['data' => $empresas]);
        }
    }

    public function tipodocIndex(Request $request)
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
            $tipos = TiposDocumento::orderBy($sortBy, $sortOrder)
                ->paginate(self::canPorPagina);
        } else {
            $tipos = TiposDocumento::orderBy($sortBy, $sortOrder)
                ->where('nombre', 'like', '%'. $buscar . '%')
                ->paginate(self::canPorPagina);
        }

        if ($request->has('ispage') && $request->ispage){
            return ['data' => $tipos];
        } else {
            return Inertia::render('Masters/TipodocIndex', ['data' => $tipos]);
        }
    }

    public function terminosIndex(Request $request)
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
            $terminos = Terminosycondiciones::orderBy($sortBy, $sortOrder)
                ->paginate(self::canPorPagina);
        } else {
            $terminos = Terminosycondiciones::orderBy($sortBy, $sortOrder)
                ->where('nombre', 'like', '%'. $buscar . '%')
                ->paginate(self::canPorPagina);
        }

        if ($request->has('ispage') && $request->ispage){
            return ['data' => $terminos];
        } else {
            return Inertia::render('Masters/TerminosIndex', ['data' => $terminos]);
        }
    }



}
