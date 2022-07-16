<?php

namespace App\Http\Controllers;

use App\Models\Caja;
use App\Models\Comision;
use App\Models\Confcomision;
use App\Models\Configuración;
use App\Models\Historialcaja;
use App\Models\Pago;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Laravel\Jetstream\Jetstream;

class ComisionController extends Controller
{
    const canPorPagina = 15;
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
            $comision = Comision::orderBy($sortBy, $sortOrder)
                ->with('venta')
                ->with('configuracion')
                ->paginate(self::canPorPagina);
        } else {
            $comision = Comision::orderBy($sortBy, $sortOrder)
                ->with('venta')
                ->with('configuracion')
                ->paginate(self::canPorPagina);
        }

        if ($request->has('ispage') && $request->ispage){
            return ['datos' => $comision];
        } else {
            return Inertia::render('Comisiones/Indexcomision', ['datos' => $comision]);
        }
    }

    public function getDetalles(Request $request)
    {
        $detalle = Detalleventa::where('idventa', $request->id)
            ->with('rifa')
            ->paginate(self::canPorPagina);

        return ['data' => $detalle];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'idmayorista' => 'required|numeric|gt:0',
            'iddistribuidor' => 'required|numeric|gt:0',
            'idvendedor' => 'required|numeric|gt:0',
        ],
            [
                'idmayorista.gt' => 'Seleccione el mayorista',
                'iddistribuidor.gt' => 'Seleccione el distribuidor',
                'idvendedor.gt' => 'Seleccione el vendedor',
                'idmayorista.required' => 'Seleccione el mayorista',
                'iddistribuidor.required' => 'Seleccione el distribuidor',
                'idvendedor.required' => 'Seleccione el vendedor',
            ]);

        $exists = Confcomision::where('idmayorista', $request->idmayorista)
            ->where('iddistribuidor', $request->iddistribuidor)
            ->where('idvendedor', $request->idvendedor)
            ->first();
        if (is_null($exists)) {
            $conf = Confcomision::create($request->all());
            $mensaje = 'Se ha creado la configuración de comisiones';
        } else {
            $mensaje = 'La configuración ya existe';
        }

        return redirect()->back()->with('message', $mensaje);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'idmayorista' => 'required|numeric|gt:0',
            'iddistribuidor' => 'required|numeric|gt:0',
            'idvendedor' => 'required|numeric|gt:0',
        ],
            [
                'idmayorista.gt' => 'Seleccione el mayorista',
                'iddistribuidor.gt' => 'Seleccione el distribuidor',
                'idvendedor.gt' => 'Seleccione el vendedor',
                'idmayorista.required' => 'Seleccione el mayorista',
                'iddistribuidor.required' => 'Seleccione el distribuidor',
                'idvendedor.required' => 'Seleccione el vendedor',
            ]);

        $comision = Confcomision::where('id', $request->id)
            ->update([
                'comisionmayorista' => $request->comisionmayorista,
                'comisiondistribuidor' => $request->comisiondistribuidor,
                'comisionvendedor' => $request->comisionvendedor
            ]);

        $mensaje = 'Se ha modificado la configuración de comisiones';

        return redirect()->back()->with('message', $mensaje);
    }


}
