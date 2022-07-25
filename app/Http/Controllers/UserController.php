<?php

namespace App\Http\Controllers;

use App\Exports\ClientesExport;
use App\Exports\UsersExport;
use App\Models\Rifa;
use App\Models\Rol;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Laravel\Jetstream\Jetstream;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;

use Illuminate\Support\Facades\Http;

class UserController extends Controller
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
        $filtros = json_decode($request->filtros);

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
                        ->with('empresa');
        } else {
            $users = User::UserApp()
                        ->orderBy($sortBy, $sortOrder)
                        ->with('ciudad')
                        ->with('rol')
                        ->with('tipodocumento')
                        ->with('empresa')
                        ->where('nombre', 'like', '%'. $buscar . '%')
                        ->orWhere('apellido', 'like', '%'. $buscar . '%')
                        ->orWhere('correo', 'like', '%'. $buscar . '%')
                        ->orWhere('username', 'like', '%'. $buscar . '%')
                        ->orWhere('documento', 'like', '%'. $buscar . '%');
        }
        if (!is_null($filtros)) {
            if (!is_null($filtros->documento) && $filtros->documento <> '') {
                $users = $users->where('documento', 'like', '%' . $filtros->documento . '%');
            }

            if (!is_null($filtros->nombre) && $filtros->nombre <> '') {
                $users = $users->where('nombre', 'like', '%' . $filtros->nombre . '%');
            }

            if (!is_null($filtros->apellido) && $filtros->apellido <> '') {
                $users = $users->where('apellido', 'like', '%' . $filtros->apellido . '%');
            }

            if (!is_null($filtros->correo) && $filtros->correo <> '') {
                $users = $users->where('correo', 'like', '%' . $filtros->correo . '%');
            }

            if (!is_null($filtros->movil) && $filtros->movil <> '') {
                $users = $users->where('movil', 'like', '%' . $filtros->movil . '%');
            }

            if (!is_null($filtros->idrol) && $filtros->idrol <> '' && $filtros->idrol <> 0) {
                $users = $users->where('idrol', 'like', '%' . $filtros->idrol . '%');
            }
        }

        $users = $users->paginate(self::canPorPagina);

        if ($request->has('ispage') && $request->ispage){
            return ['users' => $users];
        } else {
            return Inertia::render('Users/Index', ['users' => $users, '_token' => csrf_token()]);
        }
    }

    public function indexclientes(Request $request)
    {
        $buscar = $request->buscar;
        $filtros = json_decode($request->filtros);

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
            $users = User::ClientesApp()
                ->orderBy($sortBy, $sortOrder)
                ->with('ciudad')
                ->with('rol')
                ->with('tipodocumento')
                ->with('empresa');
        } else {
            $users = User::UserApp()
                ->orderBy($sortBy, $sortOrder)
                ->with('ciudad')
                ->with('rol')
                ->with('tipodocumento')
                ->with('empresa')
                ->where('nombre', 'like', '%'. $buscar . '%')
                ->orWhere('apellido', 'like', '%'. $buscar . '%')
                ->orWhere('correo', 'like', '%'. $buscar . '%')
                ->orWhere('username', 'like', '%'. $buscar . '%')
                ->orWhere('documento', 'like', '%'. $buscar . '%');
        }
        if (!is_null($filtros)) {
            if (!is_null($filtros->documento) && $filtros->documento <> '') {
                $users = $users->where('documento', 'like', '%' . $filtros->documento . '%');
            }

            if (!is_null($filtros->nombre) && $filtros->nombre <> '') {
                $users = $users->where('nombre', 'like', '%' . $filtros->nombre . '%');
            }

            if (!is_null($filtros->apellido) && $filtros->apellido <> '') {
                $users = $users->where('apellido', 'like', '%' . $filtros->apellido . '%');
            }

            if (!is_null($filtros->correo) && $filtros->correo <> '') {
                $users = $users->where('correo', 'like', '%' . $filtros->correo . '%');
            }

            if (!is_null($filtros->movil) && $filtros->movil <> '') {
                $users = $users->where('movil', 'like', '%' . $filtros->movil . '%');
            }

            if (!is_null($filtros->idrol) && $filtros->idrol <> '' && $filtros->idrol <> 0) {
                $users = $users->where('idrol', 'like', '%' . $filtros->idrol . '%');
            }
        }

        $users = $users->paginate(self::canPorPagina);

        if ($request->has('ispage') && $request->ispage){
            return ['users' => $users];
        } else {
            return Inertia::render('Users/Indexclientes', ['users' => $users, '_token' => csrf_token()]);
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

        if ($buscar == ''){
            $users = User::orderBy('users.id', 'asc')
                ->join('roles', 'users.idrol', '=', 'roles.id')
                ->select('users.id', 'users.nombre', 'users.apellido', 'users.documento', 'users.correo')
                ->where('users.estado', '=', '1')
                ->where('roles.id', '=', '5');
        } else {
            $users = User::orderBy('users.id', 'asc')
                    ->join('roles', 'users.idrol', '=', 'roles.id')
                    ->select('users.id', 'users.nombre', 'users.apellido', 'users.documento', 'users.correo')
                    ->where('users.estado', '=', '1')
                    ->where('roles.id', '=', '5')
                    ->where(function ($query) use ($buscar) {
                        return $query->where('users.nombre', 'like', "%$buscar%")
                            ->orWhere('users.apellido', 'like', '%'. $buscar . '%')
                            ->orWhere('users.documento', 'like', '%'. $buscar . '%');
                    });
        }

        if ($paginate == "true") {
            $users = $users->paginate(self::canPorPagina);
        } else {
            $users = $users->get();
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
    public function getClientesActivos(Request $request)
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
                $users = User::orderBy($sortBy, $sortOrder)
                    ->with('tipodocumento')
                    ->with('ciudad')
                    ->where('estado', '=', '1')
                    ->where('idrol', '=', '2')
                    ->paginate(self::canPorPagina);
            } else {
                $users = User::orderBy($sortBy, $sortOrder)
                    ->with('tipodocumento')
                    ->with('ciudad')
                    ->where('estado', '=', '1')
                    ->where('idrol', '=', '2')
                    //->where('fechafin', '>', $mytime->toDateString())
                    ->where(function ($query) use ($buscar) {
                        return $query->where('users.nombre', 'like', "%$buscar%")
                            ->orWhere('users.apellido', 'like', '%'. $buscar . '%')
                            ->orWhere('users.documento', 'like', '%'. $buscar . '%');
                    })
                    ->paginate(self::canPorPagina);
            }
        } else {
            if ($buscar == ''){
                $users = User::orderBy($sortBy, $sortOrder)
                        ->with('tipodocumento')
                        ->with('ciudad')
                        ->where('estado', '=', '1')
                        ->where('idrol', '=', '2')
                        //->where('fechafin', '>', $mytime->toDateString())
                        ->get();
            } else {
                $users = User::orderBy($sortBy, $sortOrder)
                        ->with('tipodocumento')
                        ->with('ciudad')
                        ->where('estado', '=', '1')
                        ->where('idrol', '=', '2')
                        //->where('fechafin', '>', $mytime->toDateString())
                        ->where(function ($query) use ($buscar) {
                            return $query->where('users.nombre', 'like', "%$buscar%")
                                  ->orWhere('users.apellido', 'like', '%'. $buscar . '%')
                                  ->orWhere('users.documento', 'like', '%'. $buscar . '%');
                        })
                        ->get();
            }
        }

        return ['clientes' => $users];
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
        Validator::make($request->all(), [
            'nombre' => ['required', 'string', 'max:255'],
            'apellido' => ['required', 'string', 'max:255'],
            'correo' => ['required', 'string', 'email', 'max:255'],
            'telefono' => ['required', 'string', 'max:255'],
            'documento' => ['required', 'string', 'max:255'],
            'documento' => ['required', 'string', 'max:255'],
            'idtipos_documento' => 'required|numeric|gt:0',
            'idpais' => 'required|numeric|gt:0',
            'iddepartamento' => 'required|numeric|gt:0',
            'idciudad' => 'required|numeric|gt:0',
            'idrol' => 'required|numeric|gt:0',
            'idempresa' => 'required|numeric|gt:0',
        ],
        [
            'nombre.required' => 'Ingrese el nombre',
            'apellido.required' => 'Ingrese el apellido',
            'correo.required' => 'Ingrese el correo',
            'telefono.required' => 'Ingrese el teléfono celular',
            'documento.required' => 'Ingrese el número de identificacion',
            'idtipos_documento.gt' => 'Seleccione una tipo de documento',
            'idpais.gt' => 'Seleccione un País',
            'iddepartamento.gt' => 'Seleccione un Departamento',
            'idrol.gt' => 'Seleccione una Ciudad',
            'idciudad.gt' => 'Seleccione un Rol',
            'idempresa.gt' => 'Seleccione una Empresa',
        ])->validate();

        $mytime= Carbon::now('America/Bogota');

        $user = User::create($request->all());
        if(!$request->cambiarpassword) {
            $user->changedpassword = $mytime->toDateString();
        } else {
            $user->changedpassword = null;
        }
        $user->password = Hash::make($user->password);
        $user->estado = true;

        $user->saveOrFail();

        $rol = Rol::where('id', $user->idrol)->first();
        $user->assignRole($rol->nombre);

        if ($user->observaciones == 'Creado por movimiento de caja') {
            return ['user' => $user];
        } else {
            return redirect()->back()->with('message', 'Cliente creado satisfactoriamente');
        }
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
        Validator::make($request->all(), [
            'nombre' => ['required', 'string', 'max:255'],
            'apellido' => ['required', 'string', 'max:255'],
            'correo' => ['required', 'string', 'email', 'max:255'],
            'telefono' => ['required', 'string', 'max:255'],
            'documento' => ['required', 'string', 'max:255'],
            'documento' => ['required', 'string', 'max:255'],
            'idtipos_documento' => 'required|numeric|gt:0',
            'idpais' => 'required|numeric|gt:0',
            'iddepartamento' => 'required|numeric|gt:0',
            'idciudad' => 'required|numeric|gt:0',
            'idrol' => 'required|numeric|gt:0',
            'idempresa' => 'required|numeric|gt:0',
        ],
            [
                'nombre.required' => 'Ingrese el nombre',
                'apellido.required' => 'Ingrese el apellido',
                'correo.required' => 'Ingrese el correo',
                'telefono.required' => 'Ingrese el teléfono celular',
                'documento.required' => 'Ingrese el número de identificacion',
                'idtipos_documento.gt' => 'Seleccione una tipo de documento',
                'idpais.gt' => 'Seleccione un País',
                'iddepartamento.gt' => 'Seleccione un Departamento',
                'idrol.gt' => 'Seleccione una Ciudad',
                'idciudad.gt' => 'Seleccione un Rol',
                'idempresa.gt' => 'Seleccione una Empresa',
            ])->validate();

        $mytime= Carbon::now('America/Bogota');

        $user = User::where('id', $request->id)->first();
        $user->update([
                              'nombre' => $request->nombre,
                              'apellido' => $request->apellido,
                              'username' => $request->username,
                              'correo' => $request->correo,
                              'movil' => $request->movil,
                              'telefono' => $request->telefono,
                              'direccion' => $request->direccion,
                              'idpais' => $request->idpais,
                              'iddepartamento' => $request->iddepartamento,
                              'idciudad' => $request->idciudad,
                              'idempresa' => $request->idempresa,
                              'idrol' => $request->idrol,
                              'idtipos_documento' => $request->idtipos_documento,
                              'documento' => $request->documento,
                              'changedpassword' => $request->cambiarpassword?null:$mytime->toDateString(),
                          ]
                      );
        $user->saveOrFail();

        $rol = Role::where('id', $user->idrol)->first();
        $user->syncRoles($rol);

        return redirect()->back()->with('message', 'Usuario modificado satisfactoriamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $user = User::where('id', $request->id)->first();
        $user->estado = !$user->estado;
        $user->save();

        return redirect()->back()->with('message', 'Usuario modificado satisfactoriamente');
    }

    public function UsersExport(Request $request)
    {
        return Excel::download(new UsersExport($request), 'users.xlsx');
    }

    public function ClientesExport(Request $request)
    {
        return Excel::download(new ClientesExport($request), 'clientes.xlsx');
    }

}
