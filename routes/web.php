<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
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
use \App\Http\Controllers\EmailController;
use \App\Http\Controllers\LoginController;
use \App\Http\Controllers\RoleController;
use \App\Http\Controllers\CajaController;
use \App\Http\Controllers\ConfcomisionController;
use \App\Http\Controllers\TransaccionController;
*/
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

    Route::get('/', [LoginController::class, 'index'])->name('login.index');
    Route::post('/', [LoginController::class, 'authenticate'])->name('login.authenticate');
    Route::get('/loginvendedor', [LoginController::class, 'indexVendedor'])->name('loginvendedor.index');
    Route::post('/loginvendedor', [LoginController::class, 'authenticatevendedor'])->name('loginvendedor.authenticate');

    Route::get('/change-password', [LoginController::class, 'changePassword'])->name('changepassword.index');
    Route::post('/change-password', [LoginController::class, 'updatePassword'])->name('changepassword.update');


    /*
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
*/

    Route::get('/ventas/sumary', [VentaController::class, 'sumary'])->name('sumary');

});



Route::middleware(['auth:sanctum', config('jetstream.auth_session'),'verified',])->group(function () {
   // Route::group(['middleware' => ['changepassword']], function () {
    Route::get('/change-password', [LoginController::class, 'changePassword'])->name('changepassword.index');
    Route::post('/change-password', [LoginController::class, 'updatePassword'])->name('changepassword.update');
    Route::post('/change-passwordsu', [LoginController::class, 'updatePasswordsu'])->name('changepassword.updatesu');




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

        Route::get('/ventas/sumary', [VentaController::class, 'sumary'])->name('sumary');

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

        Route::get('/cajas/open', [CajaController::class, 'open'])->name('cajas.open');
        Route::post('/cajas/apertura', [CajaController::class, 'apertura'])->name('cajas.apertura');
        Route::post('/cajas/cierre', [CajaController::class, 'cierre'])->name('cajas.cierre');
        Route::get('/cajas', [CajaController::class, 'index'])->name('cajas.index');
        Route::get('/cajas/historial', [CajaController::class, 'historial'])->name('cajas.historial');
        Route::resource('transacciones',TransaccionController::class);
        Route::resource('pagos',Pagocontroller::class);

        Route::get('/ventas/getComisiones', [VentaController::class, 'getComisiones'])->name('ventas.getComisiones');

        Route::resource('rifas', RifaController::class);
        Route::resource('confcomisiones',ConfcomisionController::class);
        Route::resource('comisiones',ComisionController::class);
        Route::resource('transacciones',TransaccionController::class);

        Route::resource('roles', RoleController::class);

        Route::get('/numerosreservados', [NumeroreservadoController::class, 'index'])->name('numerosreservados.index');

        Route::resource('numerosreservados', NumeroreservadoController::class);

        Route::get('/ventas/getDetalles', [VentaController::class, 'getDetalles'])->name('ventas.getDetalles');
        Route::get('/ventas/valBoletaLibre', [VentaController::class, 'valBoletaLibre'])->name('ventas.valBoletaLibre');
        Route::get('/ventas/getRandBoletaLibre', [VentaController::class, 'getRandBoletaLibre'])->name('ventas.getRandBoletaLibre');

        Route::get('/ventas/reportpdf', [VentaController::class, 'reportpdf'])->name('reportpdf');
        Route::resource('ventas', VentaController::class);

        Route::get('/cart/validarId', [CartController::class, 'validarId'])->name('validarId');
        Route::resource('/cart', CartController::class);

        Route::get('/master/getEmpresas', [MasterController::class, 'getEmpresas'])->name('master.getEmpresas');
        Route::get('/master/getRoles', [MasterController::class, 'getRoles'])->name('master.getRoles');
        Route::get('/master/index', [MasterController::class, 'rolesIndex'])->name('master.index');
        Route::get('/master/rolesshow', [MasterController::class, 'rolesshow'])->name('master.rolesshow');
        Route::get('/master/rolesedit', [MasterController::class, 'rolesedit'])->name('master.rolesedit');
        Route::post('/master/rolesupdate', [MasterController::class, 'rolesupdate'])->name('master.rolesupdate');
        Route::get('/master/paises', [MasterController::class, 'paisesIndex'])->name('master.paises');
        Route::get('/master/empresas', [MasterController::class, 'empresasIndex'])->name('master.empresas');
        Route::get('/master/series', [MasterController::class, 'seriesIndex'])->name('master.series');
        Route::get('/master/terminos', [MasterController::class, 'terminosIndex'])->name('master.terminos');
        Route::get('/master/tiposdoc', [MasterController::class, 'tipodocIndex'])->name('master.tiposdoc');
        Route::get('/master/puntoventas', [PuntoventaController::class, 'index'])->name('master.puntosventa');
        Route::get('/master/tiposdoc', [MasterController::class, 'tipodocIndex'])->name('master.tiposdoc');
        Route::get('/master/tiposdocsearch', [MasterController::class, 'tipodocSearch'])->name('master.tiposdocsearch');

        Route::get('/enviar', [EmailController::class, 'send'])->name('enviar');
        Route::get('/detalleventa', [EmailController::class, 'send'])->name('detalleventa');

    //});
});




