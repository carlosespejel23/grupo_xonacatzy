<?php

use App\Http\Controllers\AdminEstadisticaController;
use App\Http\Controllers\AdministradorController;
use App\Http\Controllers\DiaVentasController;
use App\Http\Controllers\EliminarDatosController;
use App\Http\Controllers\EmpaqueEstadisticaController;
use App\Http\Controllers\RADController;
use App\Http\Controllers\IDSController;
use App\Http\Controllers\ProductoEstadisticaController;
use App\Http\Controllers\SemillaEstadisticaController;
use App\Http\Controllers\BusquedaController;
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
    Route::delete('/dashboard/registro/{id}', [RADController::class, 'delete'])->name('dashboard-delete');
    Route::delete('/dashboard/tarea/{id}', [RADController::class, 'tarea_delete'])->name('tarea-delete');

    //Seccion "Inventario de Semillas (IDS)"
    Route::get('/inventario-semillas', [IDSController::class, 'index'])->name('inventario.index'); //Tambien para la busqueda de cultivos
    Route::post('/inventario-semillas/semillas', [IDSController::class, 'semilla_create'])->name('inventario.semilla-create');
    Route::patch('/inventario-semillas/semillas/{id}', [IDSController::class, 'semilla_update'])->name('inventario.semilla-update');
    Route::delete('/inventario-semillas/registro-entrada/delete/{id}', [IDSController::class, 'registro_historial_delete'])->name('inventario.registro-entrada-delete');
    Route::delete('/inventario-semillas/registro-salida/delete/{id}', [IDSController::class, 'registro_delete'])->name('inventario.registro-salida-delete');
    Route::get('/inventario-semillas/semillas/provedores', [IDSController::class, 'provedor'])->name('inventario.provedor');
    Route::post('/inventario-semillas/semillas/provedores', [IDSController::class, 'provedor_create'])->name('inventario.provedor-create');
    Route::patch('/inventario-semillas/semillas/provedores/{id}', [IDSController::class, 'provedor_update'])->name('inventario.provedor-update');
        //Registros
        Route::get('/inventario-semillas/semilla/{id}', [IDSController::class, 'registros'])->name('inventario.registros');
        Route::post('/inventario-semillas/semilla/{id}', [IDSController::class, 'registro_create'])->name('inventario.registro-create');
        Route::patch('/inventario-semillas/semilla/{id}', [IDSController::class, 'registro_update'])->name('inventario.registro-update');
        //Estadisticas de venta (solo para administrador)
        Route::get('/inventario-semillas/estadistica/semilla/{id}', [SemillaEstadisticaController::class, 'estadisticas_index'])->name('inventario.estadisticas');
        Route::get('/inventario-semillas/estadistica/semilla/meses/{id}', [SemillaEstadisticaController::class, 'estadisticas_12meses'])->name('inventario.estadisticas-12meses');
        Route::get('/inventario-semillas/estadistica/semilla/{id}/fecha1/{fechaInicio}/fecha2/{fechaFin}', [SemillaEstadisticaController::class, 'estadisticas_rangos'])->name('inventario.estadisticas-rangos');
        //Estadisticas de empaque (solo para administrador)
        Route::get('/inventario-semillas/estadistica/empaque-semilla/{id}', [EmpaqueEstadisticaController::class, 'empaque_estadisticas_index'])->name('inventario.estadisticas-empaque');
        Route::get('/inventario-semillas/estadistica/empaque-semilla/meses/{id}', [EmpaqueEstadisticaController::class, 'empaque_estadisticas_12meses'])->name('inventario.estadisticas-empaque-12meses');
        Route::get('/inventario-semillas/estadistica/empaque-semilla/{id}/fecha1/{fechaInicio}/fecha2/{fechaFin}', [EmpaqueEstadisticaController::class, 'empaque_estadisticas_rangos'])->name('inventario.estadisticas-empaque-rangos');

    //Seccion "Dia de Ventas"
    Route::get('/dia-ventas', [DiaVentasController::class, 'index'])->name('diaVentas.index');
    Route::post('/dia-ventas/mercado', [DiaVentasController::class, 'mercado_create'])->name('diaVentas.mercado-create');
    Route::post('/dia-ventas/cultivo', [DiaVentasController::class, 'ventas_create'])->name('diaVentas.ventas_create');
    Route::post('/dia-ventas/gastos', [DiaVentasController::class, 'gastos_create'])->name('diaVentas.gastos_create');
    Route::get('/dia-ventas/gastosTotal/{fecha}', [DiaVentasController::class, 'consultar_datos'])->name('diaVentas.consultar-datos');
    Route::delete('/dia-ventas/ventas-cultivos/delete/{id}', [DiaVentasController::class, 'ventas_cultivos_delete'])->name('diaVentas.ventas-cultivos-delete');
    Route::delete('/dia-ventas/ventas-productos/delete/{id}', [DiaVentasController::class, 'ventas_productos_delete'])->name('diaVentas.ventas-productos-delete');
    Route::delete('/dia-ventas/gastos-extra/delete/{id}', [DiaVentasController::class, 'gastos_extra_delete'])->name('diaVentas.gastos-extra-delete');

    //Panel de administrador (navbar)
    Route::get('/administrador', [AdminEstadisticaController::class, 'index'])->name('administrador.index');
    Route::get('/administrador/usuarios', [AdministradorController::class, 'usuarios'])->name('administrador.usuarios');
    Route::get('/administrador/cultivos', [AdministradorController::class, 'cultivos'])->name('administrador.cultivos');
    Route::get('/administrador/productos', [AdministradorController::class, 'productos'])->name('administrador.productos');
    Route::get('/administrador/eliminar-informacion', [EliminarDatosController::class, 'index'])->name('administrador.eliminar-datos');

    //Panel de administrador "Seccion Estadisticas de Venta de todos los Cultivos"
    Route::get('/administrador/semillas/meses', [AdminEstadisticaController::class, 'estadisticas_12meses'])->name('administrador.estadisticas-12meses');
    Route::get('/administrador/semillas/fecha1/{fechaInicio}/fecha2/{fechaFin}', [AdminEstadisticaController::class, 'estadisticas_rangos'])->name('administrador.estadisticas-rangos');

    //Panel de administrador "Seccion Estadisticas de Venta de Productos"
    Route::get('/administrador/estadistica/producto/{id}', [ProductoEstadisticaController::class, 'estadisticas_index'])->name('administrador.estadisticas-productos');
    Route::get('/administrador/estadistica/producto/meses/{id}', [ProductoEstadisticaController::class, 'estadisticas_12meses'])->name('administrador.estadisticas-12meses-productos');
    Route::get('/administrador/estadistica/producto/{id}/fecha1/{fechaInicio}/fecha2/{fechaFin}', [ProductoEstadisticaController::class, 'estadisticas_rangos'])->name('administrador.estadisticas-rangos-productos');

    //Panel de administrador "Seccion Usuarios" (Eliminar un usuario)
    Route::delete('/administrador/usuarios/{id}', [AdministradorController::class, 'usuario_delete'])->name('administrador.usuario-delete');

    //Panel de administrador "Seccion Productos"
    Route::post('/administrador/productos', [AdministradorController::class, 'producto_create'])->name('administrador.producto-create');
    Route::patch('/administrador/productos/{id}', [AdministradorController::class, 'producto_update'])->name('administrador.producto-update');

    //Panel de administrador "Eliminar Informacion"
    Route::delete('/administrador/eliminar-informacion/semilla/{id}', [EliminarDatosController::class, 'semilla_delete'])->name('administrador.semilla-delete');
    Route::delete('/administrador/eliminar-informacion/provedor/{id}', [EliminarDatosController::class, 'provedor_delete'])->name('administrador.provedor-delete');
    Route::delete('/administrador/eliminar-informacion/mercado/{id}', [EliminarDatosController::class, 'mercado_delete'])->name('administrador.mercado-delete');
    Route::delete('/administrador/eliminar-informacion/producto/{id}', [EliminarDatosController::class, 'producto_delete'])->name('administrador.producto-delete');
    Route::delete('/administrador/eliminar-informacion/actividades-diarias', [EliminarDatosController::class, 'rad_delete'])->name('administrador.actividades-delete');
    Route::delete('/administrador/eliminar-informacion/ventas', [EliminarDatosController::class, 'diaVentas_delete'])->name('administrador.ventas-delete');
    Route::delete('/administrador/eliminar-informacion/registro/semilla/{id}', [EliminarDatosController::class, 'registrosSemilla_delete'])->name('administrador.registros-delete');
});
