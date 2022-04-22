<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::join('detalle_users', 'users.id','=', 'detalle_users.id')
                     ->join('roles', 'detalle_users.idrol', '=', 'roles.id')
                     ->join('ciudades', function ($join) {
                         $join->on('detalle_users.idciudad', '=', 'ciudades.id')
                              ->on('detalle_users.idpais', '=', 'ciudades.idpais')
                              ->on('detalle_users.iddepartamento', '=', 'ciudades.iddepartamento');
                     })
                     ->select('users.id', 'detalle_users.num_documento as documento',
                             'users.name as nombre', 'detalle_users.movil as celular',
                             'users.email as correo', 'roles.nombre as perfil', 'ciudades.nombre as ciudad')
                     ->orderBy('users.id', 'desc')->paginate(2);

       return Inertia::render('Users/Index', ['users' => $users]);
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
