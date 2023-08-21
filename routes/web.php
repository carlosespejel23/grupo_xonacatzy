<?php

use App\Http\Controllers\AdministradorController;
use App\Http\Controllers\RADController;
use App\Http\Controllers\IDSController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\RoutePath;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

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

//Ruta principal de Inicio de Sesion
Route::get(RoutePath::for('login', '/'), [AuthenticatedSessionController::class, 'create'])
    ->middleware(['guest:'.config('fortify.guard')])
    ->name('login');

//Rutas protegidas por autenticacion
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    //Seccion "Reportes de Actividades Diarias (RAD)"
    Route::get('/dashboard', [RADController::class, 'index'])->name('dashboard');

    //Seccion "Inventario de Semillas (IDS)"
    Route::get('/inventario-semillas', [IDSController::class, 'index'])->name('inventario.index');

    //Panel de administrador
    Route::get('/administrador', [AdministradorController::class, 'index'])->name('administrador.index');
    Route::get('/administrador/usuarios', [AdministradorController::class, 'usuarios'])->name('administrador.usuarios');
    Route::get('/administrador/cultivos', [AdministradorController::class, 'cultivos'])->name('administrador.cultivos');
    Route::get('/administrador/productos', [AdministradorController::class, 'productos'])->name('administrador.productos');
    Route::get('/administrador/ventas', [AdministradorController::class, 'ventas'])->name('administrador.ventas');

    //Panel de administrador "Seccion Usuarios"
    Route::delete('/administrador/usuarios/{id}', [AdministradorController::class, 'usuario_delete'])->name('administrador.usuario-delete');
});
