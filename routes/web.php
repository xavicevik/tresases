<?php

namespace App\Http\Controllers;

use App\Exports\BoletasExport;
use App\Exports\VentasExport;
use App\Imports\NumeroreservadoImport;
use \Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use \App\Models\Loteria;
use \App\Models\Rol;
use \App\Models\Terminosycondiciones;
use App\Exports\ProductsExport;
use Maatwebsite\Excel\Facades\Excel;
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

    Route::get('/changepass', [LoginController::class, 'changePassword'])->name('changepass.index');
    Route::post('/changepass', [LoginController::class, 'updatePassword'])->name('changepass.update');


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
    Route::post('/changepasssu', [LoginController::class, 'updatePasswordsu'])->name('changepass.updatesu');

        Route::get('/dashboard', function () {
            return Inertia::render('Dashboard');
        })->name('dashboard');

        // export
        Route::get('/users/export', [UserController::class, 'UsersExport'])->name('users.export');
        Route::get('/clientes/export', [UserController::class, 'ClientesExport'])->name('clientes.export');

        Route::get('/boletas/export', function (Request $request) {
            return Excel::download(new BoletasExport($request), 'boletas.xlsx');
        })->name('boletas.export');

        Route::get('/reservas/export', function (Request $request) {
            return Excel::download(new VentasExport($request), 'reservas.xlsx');
        })->name('reservas.export');

        Route::post('/numerosreservados/import', function (Request $request) {
            Excel::import(new NumeroreservadoImport($request), $request->file('file'));

            return redirect()->back()->with('message', 'Archivo importado correctamente');
        })->name('numerosreservados.import');


        Route::get('/loterias', [MasterController::class, 'loterias'])->name('loterias');
        Route::get('/terminos', [MasterController::class, 'terminos'])->name('terminos');
        Route::get('/users/getClientes', [UserController::class, 'getClientes'])->name('users.clientes');
        Route::get('/ventas/sumary', [VentaController::class, 'sumary'])->name('sumary');
        Route::resource('series', SerieController::class);

        Route::get('/users/getVendedoresActivos', [UserController::class, 'getVendedoresActivos'])->name('users.getVendedoresActivos');
        Route::get('/users/getClientesActivos', [UserController::class, 'getClientesActivos'])->name('users.getClientesActivos');
        Route::get('/users/indexclientes', [UserController::class, 'indexclientes'])->name('users.indexclientes');
        Route::get('/users/indexvendedores', [UserController::class, 'indexvendedores'])->name('users.indexvendedores');
        Route::get('/users/getConfVendedor', [UserController::class, 'getConfVendedor'])->name('users.getConfVendedor');
        Route::put('/users/vendedor/{vendedor}', [UserController::class, 'updateVendedor'])->name('users.updateVendedor');
        Route::put('/users/cliente/{cliente}', [UserController::class, 'updateCliente'])->name('users.updateCliente');

        Route::resource('users', UserController::class);

       // Route::resource('/puntoventas', PuntoventaController::class);

        Route::get('/paises/departamentos', [PaisController::class, 'departamentos']);
        Route::get('/paises/ciudades', [PaisController::class, 'ciudades']);

        Route::resource('paises', PaisController::class);

        Route::post('/rifas/copy', [RifaController::class, 'copy'])->name('rifas.copy');
        Route::get('/rifas/getRifasActivas', [RifaController::class, 'getRifasActivas'])->name('rifas.getRifasActivas');
        Route::get('/rifas/indexboletas', [RifaController::class, 'indexboletas'])->name('rifas.indexboletas');
        Route::get('/rifas/getHistorialBoleta', [RifaController::class, 'getHistorialBoleta'])->name('rifas.getHistorialBoleta');

        Route::get('/cajas/movimientos', [CajaController::class, 'movimientos'])->name('cajas.movimientos');
        Route::get('/cajas/open', [CajaController::class, 'open'])->name('cajas.open');
        Route::post('/cajas/apertura', [CajaController::class, 'apertura'])->name('cajas.apertura');
       // Route::post('/cajas/cierre', [CajaController::class, 'cierre'])->name('cajas.cierre');
        Route::get('/cajas/cierre', [CajaController::class, 'cierre'])->name('cajas.cierre');
        Route::get('/cajas/printcierre', [CajaController::class, 'printcierre'])->name('cajas.printcierre');
        Route::get('/cajas', [CajaController::class, 'index'])->name('cajas.index');
        Route::get('/cajas/historial', [CajaController::class, 'historial'])->name('cajas.historial');
        Route::get('/cajas/getHistorial', [CajaController::class, 'getHistorial'])->name('cajas.getHistorial');

        Route::resource('transacciones',TransaccionController::class);
        Route::resource('pagos',Pagocontroller::class);

        Route::get('/ventas/getComisiones', [VentaController::class, 'getComisiones'])->name('ventas.getComisiones');
        Route::get('/ventas/reportpdfRegistroMov', [VentaController::class, 'reportpdfRegistroMov'])->name('ventas.reportpdfRegistroMov');
        Route::get('/ventas/reportpdfAnulaMov', [VentaController::class, 'reportpdfAnulaMov'])->name('ventas.reportpdfAnulaMov');
        Route::get('/ventas/sendSmsSales', [VentaController::class, 'sendSmsSales'])->name('ventas.sendSmsSales');
        Route::get('/ventas/initSession', [VentaController::class, 'initSession'])->name('ventas.initSession');
        Route::get('/ventas/updateSession', [VentaController::class, 'updateSession'])->name('ventas.updateSession');
        Route::get('/ventas/updDetailSession', [VentaController::class, 'updDetailSession'])->name('ventas.updDetailSession');
        Route::get('/ventas/finishSession', [VentaController::class, 'finishSession'])->name('ventas.finishSession');
        Route::get('/ventas/anularVenta', [VentaController::class, 'anularVenta'])->name('ventas.anularVenta');


        Route::resource('rifas', RifaController::class);
        Route::resource('confcomisiones',ConfcomisionController::class);
        Route::resource('comisiones',ComisionController::class);
        Route::resource('transacciones',TransaccionController::class);

        Route::resource('roles', RoleController::class);

        Route::get('/numerosreservados', [NumeroreservadoController::class, 'index'])->name('numerosreservados.index');
        Route::get('/numerosreservados/valBoletaDisponible', [NumeroreservadoController::class, 'valBoletaDisponible'])->name('numerosreservados.valBoletaDisponible');
        Route::get('/numerosreservados/valBoletaOcupada', [NumeroreservadoController::class, 'valBoletaOcupada'])->name('numerosreservados.valBoletaOcupada');
        Route::get('/numerosreservados/eliminarReserva', [NumeroreservadoController::class, 'eliminarReserva'])->name('numerosreservados.eliminarReserva');
        Route::get('/numerosreservados/reportpdfAsignacion', [NumeroreservadoController::class, 'reportpdfAsignacion'])->name('numerosreservados.reportpdfAsignacion');
        Route::get('/numerosreservados/reportpdfDesasignacion', [NumeroreservadoController::class, 'reportpdfDesasignacion'])->name('numerosreservados.reportpdfDesasignacion');
        Route::get('/numerosreservados/reportpdfCliente', [NumeroreservadoController::class, 'reportpdfCliente'])->name('numerosreservados.reportpdfCliente');


        Route::get('/numerosreservados/getBoletaOcupadaVenta', [NumeroreservadoController::class, 'getBoletaOcupadaVenta'])->name('numerosreservados.getBoletaOcupadaVenta');
        Route::get('/numerosreservados/getBoletaVendida', [NumeroreservadoController::class, 'getBoletaVendida'])->name('numerosreservados.getBoletaVendida');

        Route::resource('numerosreservados', NumeroreservadoController::class);

        Route::get('/ventas/getDetalles', [VentaController::class, 'getDetalles'])->name('ventas.getDetalles');
        Route::get('/ventas/getDetallesHistorial', [VentaController::class, 'getDetallesHistorial'])->name('ventas.getDetallesHistorial');
        Route::get('/ventas/valBoletaLibre', [VentaController::class, 'valBoletaLibre'])->name('ventas.valBoletaLibre');
        Route::get('/ventas/getRandBoletaLibre', [VentaController::class, 'getRandBoletaLibre'])->name('ventas.getRandBoletaLibre');

        Route::get('/ventas/reportpdf', [VentaController::class, 'reportpdf'])->name('reportpdf');
        Route::resource('ventas', VentaController::class);

        Route::get('/cart/validarId', [CartController::class, 'validarId'])->name('validarId');
        Route::resource('/cart', CartController::class);

        Route::get('/master/getDashboard', [MasterController::class, 'getDashboard'])->name('master.getDashboard');
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




