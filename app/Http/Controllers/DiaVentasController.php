<?php

namespace App\Http\Controllers;

use App\Models\Cultivo;
use App\Models\Gasto_Extra;
use App\Models\Mercado;
use App\Models\Producto;
use App\Models\Venta_Cultivo;
use App\Models\Venta_Producto;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DiaVentasController extends Controller
{
    //Renderiza la seccion de Dia de Ventas
    public function index(Request $request) {
        $userId = $request->user()->id;

        // Verifica si el rol del usuario es'Administrador'
        if (DB::table('users')->where('id', $userId)->where('tipoUsuario', 'Administrador')) {
            //Extrae la hora actual
            $zonaHoraria = new DateTimeZone('America/Mexico_City');
            $fechaActual = new DateTime('now', $zonaHoraria);
            $fechaActualStr = $fechaActual->format('Y-m-d');

            //Consulta a la tabla ventas_cultivos
            $ventas_cultivos = DB::table('ventas_cultivos')
                ->select(
                    'ventas_cultivos.id',
                    'cultivos.nombre as cultivo',
                    'ventas_cultivos.cantidad',
                    'ventas_cultivos.monto',
                    'ventas_cultivos.fecha',
                )
                ->join('cultivos', 'cultivos.id', '=', 'ventas_cultivos.cultivo_id')
                ->whereDate('ventas_cultivos.fecha', '=', $fechaActualStr)
                ->orderBy('ventas_cultivos.created_at', 'asc')
                ->get();

            //Consulta a la tabla ventas_productos
            $ventas_productos = DB::table('ventas_productos')
                ->select(
                    'ventas_productos.id',
                    'productos.nombre as producto',
                    'productos.precio as monto',
                    'ventas_productos.cantidad',
                    'ventas_productos.fecha',
                    DB::raw('ventas_productos.cantidad * productos.precio as total')
                )
                ->join('productos', 'productos.id', '=', 'ventas_productos.producto_id')
                ->whereDate('ventas_productos.fecha', '=', $fechaActualStr)
                ->orderBy('ventas_productos.created_at', 'asc')
                ->get();

            //Consulta a la tabla gastos_extra
            $gastos_extras = DB::table('gastos_extras')
                ->select(
                    'gastos_extras.id',
                    'gastos_extras.nombre',
                    'gastos_extras.monto',
                    'gastos_extras.fecha',
                )
                ->whereDate('gastos_extras.fecha', '=', $fechaActualStr)
                ->orderBy('gastos_extras.created_at', 'asc')
                ->get();

            // Sumar los totales de las tablas
            $totalVentasCultivos = $ventas_cultivos->sum('monto');
            $totalVentasProductos = $ventas_productos->sum('total');
            $totalGastosExtra = $gastos_extras->sum('monto');

            // Sumar los totales de ventas_cultivos y ventas_productos
            $totalVentas = $totalVentasCultivos + $totalVentasProductos;

            //Consulta a los mercados
            $mercados = Mercado::orderBy('nombre', 'asc')->get();
            //Consulta a los cultivos
            $cultivos = Cultivo::orderBy('nombre', 'asc')->get();
            $productos = Producto::orderBy('nombre', 'asc')->get();

            return view('diaVentas.diaVentas', compact('mercados', 'cultivos', 'productos', 'ventas_cultivos', 'ventas_productos', 'gastos_extras', 'totalVentas', 'totalGastosExtra'));
        } else {
            return view('dashboard');
        }
    }

    //Crea un registro en Mercados
    public function mercado_create(Request $request) {
        $userId = $request->user()->id;

        // Verifica si el rol del usuario es'Administrador'
        if (DB::table('users')->where('id', $userId)->where('tipoUsuario', 'Administrador')) {
            $validated = $request->validate([
                'nombre' => 'required',
            ]);
    
            // Crear una nueva instancia del modelo Mercado
            $mercado = new Mercado;
            $mercado->nombre = $request->nombre;
    
            $mercado->save();
    
            session()->flash('flash.banner', 'El mercado se ha registrado correctamente');
            session()->flash('flash.bannerStyle', 'success');

            return redirect()->route('diaVentas.index');
        } else {
            return view('dashboard');
        }
    }

    //Crea un registro en la tabla "Ventas"
    public function ventas_create(Request $request) {
        $userId = $request->user()->id;

        // Verifica si el rol del usuario es'Administrador'
        if (DB::table('users')->where('id', $userId)->where('tipoUsuario', 'Administrador')) {
            // Validación para Cultivos y/o Semillas
            $validated = $request->validate([
                'cultivo_id.*' => 'nullable',
                'cantidad.*' => 'nullable',
                'monto.*' => 'nullable',
            ]);

            // Validación para Productos
            $validatedProductos = $request->validate([
                'producto_id.*' => 'nullable',
                'cantidad1.*' => 'nullable',
                'monto1.*' => 'nullable',
            ]);

            // Obtener la fecha y el ID del mercado de los campos ocultos
            $fecha = $request->input('fecha_hidden');
            $mercadoId = $request->input('mercado_id_hidden');

            // Obtener los arrays de datos de la sección 1 (Cultivos y/o Semillas)
            $cantidades_seccion1 = $request->input('cantidad');
            $cultivos_id_seccion1 = $request->input('cultivo_id');
            $montos_seccion1 = $request->input('monto');

            // Obtener los arrays de datos de la sección 2 (Productos)
            $productos_id_seccion2 = $request->input('producto_id');
            $cantidades_seccion2 = $request->input('cantidad1');

            try {
                // Verificar si la fecha es nula o tiene un formato incorrecto
                if (empty($fecha)) {
                    throw new \Exception('La fecha de ventas es nula o tiene un formato incorrecto.');
                }

                // Iterar sobre los datos de la sección 1 (Cultivos y/o Semillas)
                if (!empty($cantidades_seccion1)) {
                    foreach ($cantidades_seccion1 as $key => $cantidad) {
                        // Asegurarse de que $cantidad no sea nulo antes de intentar insertar
                        if ($cantidad !== null) {
                            $ventas = new Venta_Cultivo;
                            $ventas->fecha = $fecha;
                            $ventas->mercado_id = $mercadoId;
                            $ventas->cantidad = $cantidad;
                            $ventas->cultivo_id = $cultivos_id_seccion1[$key] ?? null;
                            $ventas->monto = $montos_seccion1[$key];
                            $ventas->save();
                        }
                    }
                }
            } catch (\Exception $e) {
                // Capturamos la excepción y mostramos un mensaje de error
                session()->flash('flash.banner', 'La fecha de ventas es nula o algún campo esta vacío.');
                session()->flash('flash.bannerStyle', 'error');

                // Redirigimos de nuevo al formulario o a donde quieras
                return redirect()->route('diaVentas.index');
            }

            try {
                // Iterar sobre los datos de la sección 2 (Productos)
                if (!empty($cantidades_seccion2)) {
                    foreach ($cantidades_seccion2 as $key => $cantidad) {
                        // Asegurarse de que $cantidad no sea nulo antes de intentar insertar
                        if ($cantidad !== null) {
                            $ventas = new Venta_Producto;
                            $ventas->fecha = $fecha;
                            $ventas->mercado_id = $mercadoId;
                            $ventas->cantidad = $cantidad;
                            $ventas->producto_id = $productos_id_seccion2[$key] ?? null;
                            $ventas->save();
                        }
                    }
                }
            } catch (\Throwable $th) {
                Log::error($th); // Registrar la excepción en los registros de errores
            }
    
            session()->flash('flash.banner', 'Las ventas se han registrado correctamente');
            session()->flash('flash.bannerStyle', 'success');

            return redirect()->route('diaVentas.index');
        } else {
            return view('dashboard');
        }
    }

    //Crea un registro en la tabla "Gastos Extras"
    public function gastos_create(Request $request) {
        $userId = $request->user()->id;

        // Verifica si el rol del usuario es'Administrador'
        if (DB::table('users')->where('id', $userId)->where('tipoUsuario', 'Administrador')) {
            try {
                $validated = $request->validate([
                    'nombre.*' => 'required',
                    'monto.*' => 'required',
                ]);
    
                // Obtener el array de datos
                $nombres = $request->input('nombre');
                $montos = $request->input('monto');
                $fechas = $request->input('fecha_hidden1');
                
                foreach ($nombres as $key => $nombre) {
                    $gastos = new Gasto_Extra;
                    $gastos->nombre = $nombre;
                    $gastos->monto = $montos[$key];
                    $gastos->fecha = $fechas;
                    $gastos->save();
                }
            } catch (\Throwable $th) {
                Log::error($th); // Registrar la excepción en los registros de errores
            }

            try {
                // Verificar si la fecha es nula o tiene un formato incorrecto
                if (empty($fechas)) {
                    throw new \Exception('La fecha de ventas es nula o tiene un formato incorrecto.');
                }
            } catch (\Exception $e) {
                // Capturamos la excepción y mostramos un mensaje de error
                session()->flash('flash.banner', $e->getMessage());
                session()->flash('flash.bannerStyle', 'error');

                // Redirigimos de nuevo al formulario o a donde quieras
                return redirect()->route('diaVentas.index');
            }
    
            session()->flash('flash.banner', 'Los gastos se han registrado correctamente');
            session()->flash('flash.bannerStyle', 'success');

            return redirect()->route('diaVentas.index');
        } else {
            return view('dashboard');
        }
    }

    //Consulta los datos de la tabla ventas_cultivos, ventas_productos y gastos extra
    public function consultar_datos(Request $request, $fecha) {
        $userId = $request->user()->id;

        // Verifica si el rol del usuario es'Administrador'
        if (DB::table('users')->where('id', $userId)->where('tipoUsuario', 'Administrador')) {
            //Consulta a la tabla ventas_cultivos
            $ventas_cultivos = DB::table('ventas_cultivos')
                ->select(
                    'ventas_cultivos.id',
                    'cultivos.nombre as cultivo',
                    'ventas_cultivos.cantidad',
                    'ventas_cultivos.monto',
                    'ventas_cultivos.fecha',
                    DB::raw('ventas_cultivos.cantidad * ventas_cultivos.monto as total')
                )
                ->join('cultivos', 'cultivos.id', '=', 'ventas_cultivos.cultivo_id')
                ->whereDate('ventas_cultivos.fecha', '=', $fecha)
                ->orderBy('ventas_cultivos.created_at', 'asc')
                ->get();

            //Consulta a la tabla ventas_productos
            $ventas_productos = DB::table('ventas_productos')
                ->select(
                    'ventas_productos.id',
                    'productos.nombre as producto',
                    'productos.precio as monto',
                    'ventas_productos.cantidad',
                    'ventas_productos.fecha',
                    DB::raw('ventas_productos.cantidad * productos.precio as total')
                )
                ->join('productos', 'productos.id', '=', 'ventas_productos.producto_id')
                ->whereDate('ventas_productos.fecha', '=', $fecha)
                ->orderBy('ventas_productos.created_at', 'asc')
                ->get();

            //Consulta a la tabla gastos_extra
            $gastos_extra = DB::table('gastos_extras')
                ->select(
                    'gastos_extras.id',
                    'gastos_extras.nombre',
                    'gastos_extras.monto',
                    'gastos_extras.fecha',
                )
                ->whereDate('gastos_extras.fecha', '=', $fecha)
                ->orderBy('gastos_extras.created_at', 'asc')
                ->get();

            // Sumar los totales de las tablas
            $totalVentasCultivos = $ventas_cultivos->sum('monto');
            $totalVentasProductos = $ventas_productos->sum('total');
            $totalGastosExtra = $gastos_extra->sum('monto');

            // Sumar los totales de ventas_cultivos y ventas_productos y restarlos con los gastos extra
            $totalVentas = $totalVentasCultivos + $totalVentasProductos;

            return response()->json([$ventas_cultivos, $ventas_productos, $gastos_extra, $totalVentas, $totalGastosExtra]);
        } else{
            return response()->json(null);
        }
    }
}
