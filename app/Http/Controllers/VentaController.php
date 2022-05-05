<?php

namespace App\Http\Controllers;

use App\Models\Loteria;
use App\Models\Imagen;
use App\Models\Promocional;
use App\Models\Rifa;
use App\Models\Venta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class VentaController extends Controller
{
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
                            ->with('rifa')
                            ->with('cliente')
                            ->with('vendedor')
                            ->paginate(self::canPorPagina);
        } else {
            $ventas = Venta::orderBy($sortBy, $sortOrder)
                            ->with('puntoventa')
                            ->with('rifa')
                            ->with('cliente')
                            ->with('vendedor')
                            ->where('nombre', 'like', '%'. $buscar . '%')
                            ->orWhere('nombre_tecnico', 'like', '%'. $buscar . '%')
                            ->paginate(self::canPorPagina);
        }

        if ($request->has('ispage') && $request->ispage){
            return ['data' => $ventas];
        } else {
            return Inertia::render('Ventas/Index', ['data' => $ventas]);
        }
    }

    public function create(Request $request)
    {
        return Inertia::render('Ventas/Venta');
    }


}
