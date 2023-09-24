<?php

use App\Http\Controllers\AdministradorController;
use App\Http\Controllers\DiaVentasController;
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
    Route::post('/dashboard/cosecha', [RADController::class, 'cosecha_create'])->name('cosecha-create');
    Route::get('/dashboard/{fecha}', [RADController::class, 'cosecha_consultar'])->name('cosecha-consultar');
    Route::post('/dashboard/tareas', [RADController::class, 'tareas_create'])->name('tareas-diarias-create');
    Route::patch('/dashboard/empaque/{id}', [RADController::class, 'empaques_update'])->name('empaques-update');
    Route::post('/dashboard/combinado', [RADController::class, 'combinados_create'])->name('combinados-create');

    //Seccion "Inventario de Semillas (IDS)"
    Route::get('/inventario-semillas', [IDSController::class, 'index'])->name('inventario.index');
    Route::post('/inventario-semillas/semillas', [IDSController::class, 'semilla_create'])->name('inventario.semilla-create');
    Route::patch('/inventario-semillas/semillas/{id}', [IDSController::class, 'semilla_update'])->name('inventario.semilla-update');
    Route::delete('/inventario-semillas/semillas/{id}', [IDSController::class, 'semilla_delete'])->name('inventario.semilla-delete');
    Route::get('/inventario-semillas/semillas/provedores', [IDSController::class, 'provedor'])->name('inventario.provedor');
    Route::post('/inventario-semillas/semillas/provedores', [IDSController::class, 'provedor_create'])->name('inventario.provedor-create');
    Route::patch('/inventario-semillas/semillas/provedores/{id}', [IDSController::class, 'provedor_update'])->name('inventario.provedor-update');
    Route::delete('/inventario-semillas/semillas/provedores/{id}', [IDSController::class, 'provedor_delete'])->name('inventario.provedor-delete');

    Route::get('/inventario-semillas/semilla/{id}', [IDSController::class, 'registros'])->name('inventario.registros');
    Route::post('/inventario-semillas/semilla/{id}', [IDSController::class, 'registro_create'])->name('inventario.registro-create');
    Route::patch('/inventario-semillas/semilla/{id}', [IDSController::class, 'registro_update'])->name('inventario.registro-update');


    //Seccion "Dia de Ventas"
    Route::get('/dia-ventas', [DiaVentasController::class, 'index'])->name('diaVentas.index');

    //Panel de administrador (navbar)
    Route::get('/administrador', [AdministradorController::class, 'index'])->name('administrador.index');
    Route::get('/administrador/usuarios', [AdministradorController::class, 'usuarios'])->name('administrador.usuarios');
    Route::get('/administrador/cultivos', [AdministradorController::class, 'cultivos'])->name('administrador.cultivos');
    Route::get('/administrador/productos', [AdministradorController::class, 'productos'])->name('administrador.productos');
    Route::get('/administrador/ventas', [AdministradorController::class, 'ventas'])->name('administrador.ventas');

    //Panel de administrador "Seccion Usuarios" (Eliminar un usuario)
    Route::delete('/administrador/usuarios/{id}', [AdministradorController::class, 'usuario_delete'])->name('administrador.usuario-delete');

    //Panel de administrador "Seccion Productos"
    Route::post('/administrador/productos', [AdministradorController::class, 'producto_create'])->name('administrador.producto-create');
    Route::patch('/administrador/productos/{id}', [AdministradorController::class, 'producto_update'])->name('administrador.producto-update');
    Route::delete('/administrador/productos/{id}', [AdministradorController::class, 'producto_delete'])->name('administrador.producto-delete');
});
