<?php

namespace App\Http\Controllers;

use App\Models\Rifa;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;



class UserController extends Controller
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
            $users = User::UserApp()
                        ->orderBy($sortBy, $sortOrder)
                        ->with('ciudad')
                        ->with('rol')
                        ->with('tipodocumento')
                        ->with('empresa')
                        ->paginate(self::canPorPagina);
        } else {
            $users = User::UserApp()
                        ->orderBy($sortBy, $sortOrder)
                        ->scopeNoClientes()
                        ->with('ciudad')
                        ->with('rol')
                        ->with('tipodocumento')
                        ->with('empresa')
                        ->where('nombre', 'like', '%'. $buscar . '%')
                        ->orWhere('apellido', 'like', '%'. $buscar . '%')
                        ->orWhere('correo', 'like', '%'. $buscar . '%')
                        ->orWhere('username', 'like', '%'. $buscar . '%')
                        ->orWhere('documento', 'like', '%'. $buscar . '%')
                        ->paginate(self::canPorPagina);
        }

        if ($request->has('ispage') && $request->ispage){
            return ['users' => $users];
        } else {
            return Inertia::render('Users/Index', ['users' => $users]);
        }
    }

    public function getClientes(Request $request)
    {
        $users = User::orderBy('users.id', 'asc')
            ->join('roles', 'users.idrol', '=', 'roles.id')
            ->select('users.id', 'users.nombre', 'users.apellido')
            ->where('roles.nombre', '=', 'Cliente')->get();

        return ['users' => $users];
    }

    public function getVendedoresActivos(Request $request)
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
                $users = User::orderBy('users.id', 'asc')
                    ->join('roles', 'users.idrol', '=', 'roles.id')
                    ->select('users.id', 'users.nombre', 'users.apellido', 'users.documento', 'users.correo')
                    ->where('users.estado', '=', '1')
                    ->where('roles.id', '=', '5')
                    ->paginate(self::canPorPagina);
            } else {
                $users = User::orderBy('users.id', 'asc')
                    ->join('roles', 'users.idrol', '=', 'roles.id')
                    ->select('users.id', 'users.nombre', 'users.apellido', 'users.documento', 'users.correo')
                    ->where('users.estado', '=', '1')
                    ->where('users.'.$filtro, 'like', '%'. $buscar . '%')
                    ->where('roles.id', '=', '5')
                    ->paginate(self::canPorPagina);
            }
        } else {
            if ($buscar == ''){
                $users = User::orderBy('users.id', 'asc')
                    ->join('roles', 'users.idrol', '=', 'roles.id')
                    ->select('users.id', 'users.nombre', 'users.apellido', 'users.documento', 'users.correo')
                    ->where('users.estado', '=', '1')
                    ->where('users.'.$filtro, 'like', '%'. $buscar . '%')
                    ->where('roles.id', '=', '5')
                    ->get();
            } else {
                $users = User::orderBy('users.id', 'asc')
                        ->join('roles', 'users.idrol', '=', 'roles.id')
                        ->select('users.id', 'users.nombre', 'users.apellido', 'users.documento', 'users.correo')
                        ->where('users.estado', '=', '1')
                        ->where('users.'.$filtro, 'like', '%'. $buscar . '%')
                        ->where($filtro, 'like', '%'. $buscar . '%')
                        ->where('roles.id', '=', '5')
                        ->get();
            }
        }

        return ['vendedores' => $users];
    }

    /*
    public function buscaUsers(Request $request)
    {
        $buscar = $request->buscar;

        if (isset($request->sortBy)) {
            $sortOrder = $request->sortOrder;
            $sortBy = $request->sortBy;
        } else {
            $sortOrder = 'asc';
            $sortBy = 'detalle_users.id';
        }

        if ($buscar==''){
            $users = User::join('detalle_users', 'users.id','=', 'detalle_users.id')
                ->join('roles', 'detalle_users.idrol', '=', 'roles.id')
                ->join('ciudades', function ($join) {
                    $join->on('detalle_users.idciudad', '=', 'ciudades.id')
                        ->on('detalle_users.idpais', '=', 'ciudades.idpais')
                        ->on('detalle_users.iddepartamento', '=', 'ciudades.iddepartamento');
                })
                ->select('users.id', 'detalle_users.num_documento as documento', 'detalle_users.estado',
                    'users.name as nombre', 'detalle_users.movil as celular',
                    'users.email as correo', 'roles.nombre as perfil', 'ciudades.nombre as ciudad')
                ->orderBy($sortBy, $sortOrder)
                ->paginate(self::canPorPagina);
        } else {
            $users = User::join('detalle_users', 'users.id','=', 'detalle_users.id')
                ->join('roles', 'detalle_users.idrol', '=', 'roles.id')
                ->join('ciudades', function ($join) {
                    $join->on('detalle_users.idciudad', '=', 'ciudades.id')
                        ->on('detalle_users.idpais', '=', 'ciudades.idpais')
                        ->on('detalle_users.iddepartamento', '=', 'ciudades.iddepartamento');
                })
                ->where('users.name', 'like', '%'. $buscar . '%')
                ->orWhere('detalle_users.num_documento', 'like', '%'. $buscar . '%')
                ->orWhere('users.email', 'like', '%'. $buscar . '%')
                ->select('users.id', 'detalle_users.num_documento as documento', 'detalle_users.estado',
                    'users.name as nombre', 'detalle_users.movil as celular',
                    'users.email as correo', 'roles.nombre as perfil', 'ciudades.nombre as ciudad')
                ->orderBy($sortBy, $sortOrder)
                ->paginate(self::canPorPagina);
        }

        return ['users' => $users];
    }
    */

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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
