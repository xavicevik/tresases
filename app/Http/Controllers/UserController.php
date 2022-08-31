<?php

namespace App\Http\Controllers;

use App\Exports\ClientesExport;
use App\Exports\UsersExport;
use App\Models\Cliente;
use App\Models\Confcomision;
use App\Models\Rifa;
use App\Models\Rol;
use App\Models\User;
use App\Models\Vendedor;
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
            $users = User::orderBy($sortBy, $sortOrder)
                        ->with('ciudad')
                        ->with('rol')
                        ->with('tipodocumento')
                        ->with('empresa');
        } else {
            $users = User::orderBy($sortBy, $sortOrder)
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
            $users = Cliente::orderBy($sortBy, $sortOrder)
                ->with('ciudad')
                ->with('rol')
                ->with('tipodocumento')
                ->with('empresa');
        } else {
            $users = Cliente::orderBy($sortBy, $sortOrder)
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
            return ['clientes' => $users];
        } else {
            return Inertia::render('Users/Indexclientes', ['clientes' => $users, '_token' => csrf_token()]);
        }
    }

    public function indexvendedores(Request $request)
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
            $vendedores = Vendedor::orderBy($sortBy, $sortOrder)
                ->with('ciudad')
                ->with('rol')
                ->with('tipodocumento')
                ->with('empresa');
        } else {
            $vendedores = Vendedor::orderBy($sortBy, $sortOrder)
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
                $vendedores = $vendedores->where('documento', 'like', '%' . $filtros->documento . '%');
            }

            if (!is_null($filtros->nombre) && $filtros->nombre <> '') {
                $vendedores = $vendedores->where('nombre', 'like', '%' . $filtros->nombre . '%');
            }

            if (!is_null($filtros->apellido) && $filtros->apellido <> '') {
                $vendedores = $vendedores->where('apellido', 'like', '%' . $filtros->apellido . '%');
            }

            if (!is_null($filtros->correo) && $filtros->correo <> '') {
                $vendedores = $vendedores->where('correo', 'like', '%' . $filtros->correo . '%');
            }

            if (!is_null($filtros->movil) && $filtros->movil <> '') {
                $vendedores = $vendedores->where('movil', 'like', '%' . $filtros->movil . '%');
            }

            if (!is_null($filtros->idrol) && $filtros->idrol <> '' && $filtros->idrol <> 0) {
                $vendedores = $vendedores->where('idrol', 'like', '%' . $filtros->idrol . '%');
            }
        }

        $vendedores = $vendedores->paginate(self::canPorPagina);

        if ($request->has('ispage') && $request->ispage){
            return ['vendedores' => $vendedores];
        } else {
            return Inertia::render('Users/Indexvendedores', ['vendedores' => $vendedores, '_token' => csrf_token()]);
        }
    }

    public function getClientes(Request $request)
    {
        $users = Cliente::orderBy('id', 'asc')
                ->select('id', 'nombre', 'apellido')->get();

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
            $users = Vendedor::orderBy('id', 'asc')
                ->select('id', 'nombre', 'apellido', 'documento', 'correo')
                ->where('estado', 1);
        } else {
            $users = Vendedor::orderBy('id', 'asc')
                    ->select('id', 'nombre', 'apellido', 'documento', 'correo')
                    ->where('estado', 1)
                    ->where(function ($query) use ($buscar) {
                        return $query->where('nombre', 'like', "%$buscar%")
                            ->orWhere('apellido', 'like', '%'. $buscar . '%')
                            ->orWhere('documento', 'like', '%'. $buscar . '%');
                    });
        }

        if ($paginate == "true") {
            $users = $users->paginate(self::canPorPagina);
        } else {
            $users = $users->get();
        }
        return ['vendedores' => $users];
    }

    public function getConfVendedor(Request $request)
    {
        $concomision = Confcomision::where('idvendedor', $request->idvendedor)
            ->where('estado', 2)
            ->first();
        if (is_null($concomision)) {
            $concomision = Confcomision::join('vendedors as t1', 'confcomisiones.idvendedor', '=', 't1.idempresa')
                ->select('confcomisiones.*')
                ->where('t1.id', $request->idvendedor)
                ->first();
        }
        return ['comision' => $concomision ];
    }

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
                $users = Cliente::orderBy($sortBy, $sortOrder)
                    ->with('tipodocumento')
                    ->with('ciudad')
                    ->where('estado', 1)
                    ->paginate(self::canPorPagina);
            } else {
                $users = Cliente::orderBy($sortBy, $sortOrder)
                    ->with('tipodocumento')
                    ->with('ciudad')
                    ->where('estado', 1)
                    ->where(function ($query) use ($buscar) {
                        return $query->where('nombre', 'like', "%$buscar%")
                            ->orWhere('apellido', 'like', '%'. $buscar . '%')
                            ->orWhere('documento', 'like', '%'. $buscar . '%');
                    })
                    ->paginate(self::canPorPagina);
            }
        } else {
            if ($buscar == ''){
                $users = Cliente::orderBy($sortBy, $sortOrder)
                        ->with('tipodocumento')
                        ->with('ciudad')
                        ->where('estado', 1)
                        ->get();
            } else {
                $users = Cliente::orderBy($sortBy, $sortOrder)
                        ->with('tipodocumento')
                        ->with('ciudad')
                        ->where('estado', 1)
                        ->where(function ($query) use ($buscar) {
                            return $query->where('nombre', 'like', "%$buscar%")
                                  ->orWhere('apellido', 'like', '%'. $buscar . '%')
                                  ->orWhere('documento', 'like', '%'. $buscar . '%');
                        })->get();
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
            'idtipos_documento' => 'required|numeric|gt:0',
            'idpais' => 'required|numeric|gt:0',
            'iddepartamento' => 'required|numeric|gt:0',
            'idciudad' => 'required|numeric|gt:0',
            'idrol' => 'required|numeric|gt:0',
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
            'idrol.gt' => 'Seleccione un Rol',
            'idciudad.gt' => 'Seleccione una ciudad',
        ])->validate();

        $mytime= Carbon::now('America/Bogota');

        if ($request->idrol == 2) {
            $user = Cliente::create($request->all());
        } elseif ($request->idrol == 5) {
            $user = Vendedor::create($request->all());
        } else {
            $user = User::create($request->all());
        }

        if(!$request->cambiarpassword) {
            $user->changedpassword = $mytime->toDateString();
        } else {
            $user->changedpassword = null;
        }
        $user->password = Hash::make($user->password);
        $user->estado = true;

        $user->saveOrFail();

        $rol = Rol::where('id', $user->idrol)->first();
        //$user->assignRole($rol->nombre);

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

        //    $user = User::where('id', $request->id)->first();

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

        //$rol = Role::where('id', $user->idrol)->first();
        //$user->syncRoles($rol);

        return redirect()->back()->with('message', 'Usuario modificado satisfactoriamente');
    }

    public function updateVendedor(Request $request, Vendedor $vendedor)
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

        //$user = Vendedor::where('id', $request->id)->first();
        $user = $vendedor;

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

    public function updateCliente(Request $request, Cliente $cliente)
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
            ])->validate();

        $mytime= Carbon::now('America/Bogota');

        //$user = Cliente::where('id', $request->id)->first();
        $user = $cliente;

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
        if ($request->idrol == 2) {
            $user = Cliente::where('id', $request->id)->first();
        } elseif ($request->idrol == 5) {
            $user = Vendedor::where('id', $request->id)->first();
        } else {
            $user = User::where('id', $request->id)->first();
        }

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
