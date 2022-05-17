<?php

namespace App\Http\Controllers;

use App\Models\Serie;
use Illuminate\Http\Request;

class SerieController extends Controller
{
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
            $tiposerie = Serie::orderBy($sortBy, $sortOrder)
                ->where('estado', '=', '1')
                ->get();
                //->paginate(self::canPorPagina);
        } else {
            $tiposerie = Serie::orderBy($sortBy, $sortOrder)
                ->where('nombre', 'like', '%'. $buscar . '%')
                ->orWhere('detalle', 'like', '%'. $buscar . '%')
                ->get();
               //->paginate(self::canPorPagina);
        }

        //if ($request->has('ispage') && $request->ispage){
            return ['tiposerie' => $tiposerie];
        //} else {
        //    return Inertia::render('Puntoventas/Index', ['puntoventas' => $series]);
        //}
    }
}
