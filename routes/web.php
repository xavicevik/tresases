<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use \App\Http\Controllers\UserController;
use \App\Http\Controllers\PaisController;
use \App\Http\Controllers\PuntoventaController;
use \App\Http\Controllers\RifaController;

use \App\Models\Loteria;
use \App\Models\Terminosycondiciones;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'),'verified',])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/loterias', function () {
        return ['loterias' => Loteria::all()];
    })->name('loterias');

    Route::get('/terminos', function () {
        return ['terminos' => Terminosycondiciones::all()];
    })->name('terminos');

    Route::get('/users/buscaUsers', [UserController::class, 'buscaUsers'])
        ->name('users.buscar');

    Route::resource('users', UserController::class);

    Route::resource('/puntoventas', PuntoventaController::class);

    Route::get('/paises/departamentos', [PaisController::class, 'departamentos']);

    Route::get('/paises/ciudades', [PaisController::class, 'ciudades']);

    Route::resource('paises', PaisController::class);

    Route::resource('rifas', RifaController::class);

});




