<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NuevoConsumoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('verconsumo_periodo', [NuevoConsumoController::class, 'listadoPeriodo']);
Route::get('verconsumo_periodo/{anyo}/{idperiodo}', [NuevoConsumoController::class, 'listadoPeriodoFiltrado']);


Route::get('verPeriodos', [NuevoConsumoController::class, 'verPeriodos'])->name('verPeriodosRoute');

Route::post('verPeriodos', [NuevoConsumoController::class, 'verPeriodos'])->name('buscarPeriodo');



Route::get('/nuevoconsumo', [NuevoConsumoController::class, 'index'])->name('nuevoConsumo');
Route::post('store-form', [NuevoConsumoController::class, 'store'])->name('store-form');

/*Route::get('enviarCorreo', [NuevoConsumoController::class, 'enviarCorreoAlerta'])->name('enviarCorreo');
*/

