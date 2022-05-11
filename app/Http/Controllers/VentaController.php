<?php

namespace App\Http\Controllers;

use App\Models\Boleta;
use App\Models\Loteria;
use App\Models\Imagen;
use App\Models\Promoboleta;
use App\Models\Promocional;
use App\Models\Rifa;
use App\Models\Venta;
use Darryldecode\Cart\Cart;
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

//        \Cart::session(Auth::user()->id);
/*
        \Cart::add(array(
            'id' => 2,
            'name' => 'x2',
            'price' => '10000',
            'quantity' => 4,
            'attributes' => array(),
            'associatedModel' => Boleta::class
        ));
*/
 //       $items = \Cart::getContent();
//dd($items);

        return Inertia::render('Ventas/Venta');
    }

    public function valBoletaLibre(Request $request) {
        $cifras = $request->cifras;
        $idrifa = $request->rifa;
        $numero = str_pad($request->buscar, $cifras,"0", STR_PAD_LEFT );

        $boleta = Boleta::ForceIndex('idx_rifa_num')
                          ->where('idrifa', $idrifa)
                          ->where('estado', '<>', 1)
                          ->where('numero', $numero)
                          ->first();

        $promoboleta = Promoboleta::where('idrifa', $idrifa)
                              ->where('estado', '<>', 1)
                              ->where('numero', $numero)
                              ->get();

        return ['boleta' => $boleta, 'promoboleta' => $promoboleta];

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


}
