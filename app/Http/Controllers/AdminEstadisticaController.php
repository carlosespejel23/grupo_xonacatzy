<?php

namespace App\Http\Controllers;

use App\Models\Cultivo;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

// Controlador de las estadisticas en la seccion principal del Administrador
class AdminEstadisticaController extends Controller
{
    //Renderiza el panel principal del administrador y tambien carga los datos de las estadisticas
    public function index(Request $request) {
        $userId = $request->user()->id;

        // Verifica si el rol del usuario es'Administrador'
        if (DB::table('users')->where('id', $userId)->where('tipoUsuario', 'Administrador')) {
            // Obtener registros del modelo Cultivo
            $cultivos = Cultivo::all();

            // Configura Carbon en español
            Carbon::setLocale('es');
            // Obtiene la fecha de hoy
            $today = Carbon::now();
            // Inicializa un array para almacenar los rangos de fechas y la informacion de las ventas
            $rangosFechas = [];
            $ventas = [];

            foreach ($cultivos as $cultivo) {
                $ventasCultivo = [];
            
                $today = Carbon::now(); // Reinicializa la fecha de hoy para cada cultivo
            
                for ($i = 0; $i < 8; $i++) {
                    $endOfWeek = $today->endOfWeek();
                    $startOfWeek = $endOfWeek->copy()->subWeek();

                    // Agregar un día al inicio de la semana para evitar la repetición
                    $startOfWeek->addDay();

                    $fechaInicio = $startOfWeek->format('d/M');
                    $fechaFin = $endOfWeek->format('d/M');

                    $fechaActual = $fechaInicio . ' - ' . $fechaFin;
                    $rangosFechas[] = $fechaActual;
                    
                    // Modifica la consulta para obtener ventas específicas para cada cultivo
                    $venta = DB::table('ventas_cultivos')
                        ->select(
                            DB::raw('SUM(ventas_cultivos.monto) as suma_monto')
                        )
                        ->join('cultivos', 'cultivos.id', '=', 'ventas_cultivos.cultivo_id')
                        ->where('ventas_cultivos.cultivo_id', '=', $cultivo->id)
                        ->whereDate('ventas_cultivos.fecha', '>=', $startOfWeek)
                        ->whereDate('ventas_cultivos.fecha', '<=', $endOfWeek)
                        ->groupBy(DB::raw('YEARWEEK(ventas_cultivos.fecha)'))
                        ->get();
            
                    if ($venta->count() > 0) {
                        $sumaMonto = $venta[0]->suma_monto;
                    } else {
                        $sumaMonto = 0;
                    }
            
                    $ventasCultivo[] = $sumaMonto;
                    $today->subWeek();
                }
            
                // Revierte el orden de los datos de ventas para tener los más recientes primero
                $ventasCultivo = array_reverse($ventasCultivo);
            
                $ventas[] = $ventasCultivo;
            }
            
            // Revierte el orden de las fechas para tener las más recientes primero
            $rangosFechas = array_reverse($rangosFechas);

            try {
                $ventasSemanales = 0; // Inicializa la variable para almacenar la suma

                foreach ($ventas as $venta) {
                    // Obtén el último elemento de cada subarray
                    $ultimoElemento = end($venta);

                    // Asegúrate de que el último elemento no sea falso (puede ocurrir si el subarray está vacío)
                    if ($ultimoElemento !== false) {
                        $ventasSemanales += $ultimoElemento; // Suma el último elemento al total
                    }
                }

                //return response()->json([$cultivos, $rangosFechas, $ventas, $ventasSemanales]);
                return view('administrador.admin', compact( 
                    'cultivos', 'rangosFechas', 'ventas', 'ventasSemanales', //Grafico de Cultivos
                    
                ));
            } catch (\Throwable $th) {
                $ventasSemanales = 0;
                return view('administrador.admin', compact('cultivos', 'rangosFechas', 'ventas', 'ventasSemanales'));
            }
        } else {
            return view('dashboard');
        }
    }

    //Consulta de los ultimos 12 meses
    public function estadisticas_12meses(Request $request) {
        $userId = $request->user()->id;

        // Verifica si el rol del usuario es'Administrador'
        if (DB::table('users')->where('id', $userId)->where('tipoUsuario', 'Administrador')) {
            // Obtener registros del modelo Cultivo
            $cultivos = Cultivo::all();

            // Configura Carbon en español
            Carbon::setLocale('es');
            // Obtiene la fecha de hoy
            $today = Carbon::now();
            // Inicializa un array para almacenar los rangos de fechas y la informacion de las ventas
            $rangosFechas = [];
            $ventas = [];

            foreach ($cultivos as $cultivo) {
                $ventasCultivo = [];
            
                $today = Carbon::now(); // Reinicializa la fecha de hoy para cada mercado
                $startOfMonth = $today->copy()->startOfMonth(); // Inicializa al primer día del mes actual
            
                for ($i = 0; $i < 12; $i++) {
                    $endOfMonth = $startOfMonth->copy()->endOfMonth();
                    $fechaInicio = $startOfMonth->format('M');
                    $fechaActual = $fechaInicio;
                    $rangosFechas[] = $fechaActual;
                    
                    // Modifica la consulta para obtener ventas específicas para el mercado actual
                    $venta = DB::table('ventas_cultivos')
                        ->select(
                            DB::raw('SUM(ventas_cultivos.monto) as suma_monto')
                        )
                        ->join('cultivos', 'cultivos.id', '=', 'ventas_cultivos.cultivo_id')
                        ->where('ventas_cultivos.cultivo_id', '=', $cultivo->id)
                        ->whereDate('ventas_cultivos.fecha', '>=', $startOfMonth)
                        ->whereDate('ventas_cultivos.fecha', '<=', $endOfMonth)
                        ->groupBy(DB::raw('MONTH(ventas_cultivos.fecha)'))
                        ->get();
            
                    if ($venta->count() > 0) {
                        $sumaMonto = $venta[0]->suma_monto;
                    } else {
                        $sumaMonto = 0;
                    }
            
                    $ventasCultivo[] = $sumaMonto;
                    $startOfMonth->subMonth();
                }
            
                // Revierte el orden de los datos de ventas para tener los más recientes primero
                $ventasCultivo = array_reverse($ventasCultivo);
            
                $ventas[] = $ventasCultivo;
            }
            
            // Revierte el orden de las fechas para tener las más recientes primero
            $rangosFechas = array_reverse($rangosFechas);

            try {
                $ventasMensuales = 0; // Inicializa la variable para almacenar la suma

                foreach ($ventas as $venta) {
                    // Obtén el último elemento de cada subarray
                    $ultimoElemento = end($venta);

                    // Asegúrate de que el último elemento no sea falso (puede ocurrir si el subarray está vacío)
                    if ($ultimoElemento !== false) {
                        $ventasMensuales += $ultimoElemento; // Suma el último elemento al total
                    }
                }

                return response()->json([$cultivos, $rangosFechas, $ventas, $ventasMensuales]);
            } catch (\Throwable $th) {
                $ventasMensuales = 0;
                return response()->json([$cultivos, $rangosFechas, $ventas, $ventasMensuales]);
            }
        } else{
            return response()->json(null);
        }
    }

    //Consulta de un rango de fechas (fecha inicial y fecha final) establecida por el usuario
    public function estadisticas_rangos(Request $request, $fechaInicio, $fechaFin) {
        $userId = $request->user()->id;
    
        // Verifica si el rol del usuario es 'Administrador'
        if (DB::table('users')->where('id', $userId)->where('tipoUsuario', 'Administrador')) {
            // Obtener registros del modelo Cultivo
            $cultivos = Cultivo::all();;
    
            // Configura Carbon en español
            Carbon::setLocale('es');
    
            $fechaInicio = Carbon::parse($fechaInicio);
            $fechaFin = Carbon::parse($fechaFin);
    
            // Inicializa un array para almacenar los rangos de fechas y la información de las ventas
            $rangosFechas = [];
            $ventas = [];
    
            foreach ($cultivos as $cultivo) {
                $ventasCultivo = [];
            
                for ($fechaActual = $fechaInicio->copy(); $fechaActual->lte($fechaFin); $fechaActual->addMonth()) {
                    $parteInicio = $fechaActual->copy();
                    $parteFin = $fechaActual->copy()->addMonth();
            
                    $fechaInicioFormateada = $parteInicio->format('M/y');
                    $fechaFinFormateada = $parteFin->format('M/y');
                    $fechaActualStr = "$fechaInicioFormateada - $fechaFinFormateada";
                    $rangosFechas[] = $fechaActualStr;
            
                    $venta = DB::table('ventas_cultivos')
                        ->select(DB::raw('SUM(ventas_cultivos.monto) as suma_monto'))
                        ->join('cultivos', 'cultivos.id', '=', 'ventas_cultivos.cultivo_id')
                        ->where('ventas_cultivos.cultivo_id', '=', $cultivo->id)
                        ->whereDate('ventas_cultivos.fecha', '>=', $parteInicio)
                        ->whereDate('ventas_cultivos.fecha', '<', $parteFin)
                        ->groupBy(DB::raw('YEAR(ventas_cultivos.fecha), MONTH(ventas_cultivos.fecha)'))
                        ->get();
            
                    if ($venta->count() > 0) {
                        $sumaMonto = $venta[0]->suma_monto;
                    } else {
                        $sumaMonto = 0;
                    }
            
                    $ventasCultivo[] = $sumaMonto;
                }
            
                $ventas[] = $ventasCultivo;
            }
    
            return response()->json([$cultivos, $rangosFechas, $ventas]);
        } else {
            return response()->json(null);
        }
    }
}
