<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use \App\Http\Controllers\UserController;
use \App\Http\Controllers\PaisController;
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

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

Route::resource('users', UserController::class)
    ->middleware(['auth:sanctum', 'verified']);

Route::get('/paises/departamentos', [PaisController::class, 'departamentos'])
    ->middleware(['auth:sanctum', 'verified']);

Route::get('/paises/ciudades', [PaisController::class, 'ciudades'])
    ->middleware(['auth:sanctum', 'verified']);

Route::resource('paises', PaisController::class)
    ->middleware(['auth:sanctum', 'verified']);

