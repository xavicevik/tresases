<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use \App\Http\Controllers\UserController;
use \App\Http\Controllers\PaisController;
use \App\Http\Controllers\PuntoventaController;
use \App\Http\Controllers\RifaController;
use \App\Http\Controllers\NumeroreservadoController;
use \App\Http\Controllers\SerieController;
use \App\Http\Controllers\MasterController;
use \App\Http\Controllers\VentaController;
use \App\Http\Controllers\EmpresaController;
use \App\Http\Controllers\CartController;

use \App\Models\Loteria;
use \App\Models\Rol;
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
/*
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});
*/
Route::group(['middleware'=>['guest']],function(){

    Route::get('/', function () {
        return Inertia::render('Auth/Login', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
        ]);
    });

    Route::post('/', function () {
        return Inertia::render('Auth/Login', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register')
        ]);
    });
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

    Route::get('/users/getClientes', [UserController::class, 'getClientes'])
        ->name('users.clientes');

    Route::resource('series', SerieController::class);

    Route::get('/users/getVendedoresActivos', [UserController::class, 'getVendedoresActivos'])->name('users.getVendedoresActivos');

    Route::get('/users/getClientesActivos', [UserController::class, 'getClientesActivos'])->name('users.getClientesActivos');

    Route::resource('users', UserController::class);

   // Route::resource('/puntoventas', PuntoventaController::class);

    Route::get('/paises/departamentos', [PaisController::class, 'departamentos']);

    Route::get('/paises/ciudades', [PaisController::class, 'ciudades']);

    Route::resource('paises', PaisController::class);

    Route::post('/rifas/copy', [RifaController::class, 'copy'])->name('rifas.copy');
    Route::get('/rifas/getRifasActivas', [RifaController::class, 'getRifasActivas'])->name('rifas.getRifasActivas');


    Route::resource('rifas', RifaController::class);


    Route::get('/numerosreservados', [NumeroreservadoController::class, 'index'])->name('numerosreservados.index');

    Route::resource('numerosreservados', NumeroreservadoController::class);


    Route::get('/ventas/valBoletaLibre', [VentaController::class, 'valBoletaLibre'])->name('ventas.valBoletaLibre');
    Route::get('/ventas/getRandBoletaLibre', [VentaController::class, 'getRandBoletaLibre'])->name('ventas.getRandBoletaLibre');

    Route::resource('ventas', VentaController::class);
    Route::resource('/cart', CartController::class);

    Route::get('/master/index', [MasterController::class, 'rolesIndex'])->name('master.index');
    Route::get('/master/paises', [MasterController::class, 'paisesIndex'])->name('master.paises');
    Route::get('/master/empresas', [MasterController::class, 'empresasIndex'])->name('master.empresas');
    Route::get('/master/series', [MasterController::class, 'seriesIndex'])->name('master.series');
    Route::get('/master/terminos', [MasterController::class, 'terminosIndex'])->name('master.terminos');
    Route::get('/master/tiposdoc', [MasterController::class, 'tipodocIndex'])->name('master.tiposdoc');
    Route::get('/master/puntoventas', [PuntoventaController::class, 'index'])->name('master.puntosventa');
    Route::get('/master/tiposdoc', [MasterController::class, 'tipodocIndex'])->name('master.tiposdoc');
    Route::get('/master/tiposdocsearch', [MasterController::class, 'tipodocSearch'])->name('master.tiposdocsearch');


});




