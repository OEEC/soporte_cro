<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\SupervisorController;

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
    return view('welcome');
});
//Usuario
Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios');
Route::post('/traer_usuarios', [UsuarioController::class, 'filtro_usuarios'])->name('usuarios.filtro');
Route::get('/traer_usuario/{id}', [UsuarioController::class, 'usuario_ver'])->name('usuario.ver');
Route::post('/actualizar_usuario/{id}', [UsuarioController::class, 'usuario_actualizar'])->name('usuario.actualizar');
Route::get('/baja_usuario/{id}', [UsuarioController::class, 'usuario_baja'])->name('usuario.baja');
Route::get('/delete_usuario/{id}', [UsuarioController::class, 'delete'])->name('usuario.delete');

//Supervisor
Route::get('/supervisores', [SupervisorController::class, 'index'])->name('supervisores');
Route::get('/traer_supervisores', [SupervisorController::class, 'supervisor_filtros'])->name('supervisores.filtro');
Route::get('/supervisor_estaciones/{id}', [SupervisorController::class, 'supervisores_estaciones'])->name('supervisores.estaciones');
Route::get('/borrar_supxest/{id}', [SupervisorController::class, 'borrar_supxest'])->name('borrar.supxest');
Route::post('/asignar_estacion/{id}', [SupervisorController::class, 'asignar_estacion'])->name('asignar.supxest');