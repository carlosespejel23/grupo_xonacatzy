<?php

namespace App\Http\Controllers;

use App\Models\Cultivo;
use App\Models\Mercado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

// Controlador de las estadisticas de cada semilla en la seccion "Inventario de Semillas"
class SemillaEstadisticaController extends Controller
{
    //Renderiza la vista de Estadisticas del Cultivo
    public function estadisticas_index(Request $request, $id) {
        $userId = $request->user()->id;

        // Verifica si el rol del usuario es'Administrador'
        if (DB::table('users')->where('id', $userId)->where('tipoUsuario', 'Administrador')) {
            // Obtener registros del modelo Cultivo
            $cultivos = Cultivo::where('id', $id)->get();
            // Obtener registros del modelo Mercado
            $mercados = Mercado::all();

            // Configura Carbon en español
            Carbon::setLocale('es');
            // Obtiene la fecha de hoy
            $today = Carbon::now();
            // Inicializa un array para almacenar los rangos de fechas y la informacion de las ventas
            $rangosFechas = [];
            $ventas = [];

            foreach ($mercados as $mercado) {
                $ventasMercado = [];
            
                $today = Carbon::now(); // Reinicializa la fecha de hoy para cada mercado
            
                for ($i = 0; $i < 8; $i++) {
                    $endOfWeek = $today->endOfWeek();
                    $startOfWeek = $endOfWeek->copy()->subWeek();

                    // Agregar un día al inicio de la semana para evitar la repetición
                    $startOfWeek->addDay();

                    $fechaInicio = $startOfWeek->format('d/M');
                    $fechaFin = $endOfWeek->format('d/M');

                    $fechaActual = $fechaInicio . ' - ' . $fechaFin;
                    $rangosFechas[] = $fechaActual;
                    
                    // Modifica la consulta para obtener ventas específicas para el mercado actual
                    $venta = DB::table('ventas_cultivos')
                        ->select(
                            DB::raw('SUM(ventas_cultivos.monto) as suma_monto')
                        )
                        ->join('cultivos', 'cultivos.id', '=', 'ventas_cultivos.cultivo_id')
                        ->join('mercados', 'mercados.id', '=', 'ventas_cultivos.mercado_id')
                        ->where('ventas_cultivos.cultivo_id', '=', $id)
                        ->where('ventas_cultivos.mercado_id', '=', $mercado->id) // Filtra por el mercado actual
                        ->whereDate('ventas_cultivos.fecha', '>=', $startOfWeek)
                        ->whereDate('ventas_cultivos.fecha', '<=', $endOfWeek)
                        ->get();
            
                    $sumaMonto = $venta[0]->suma_monto ?? 0;
            
                    $ventasMercado[] = $sumaMonto;
                    $today->subWeek();
                }
            
                // Revierte el orden de los datos de ventas para tener los más recientes primero
                $ventasMercado = array_reverse($ventasMercado);
            
                $ventas[] = $ventasMercado;
            }
            
            // Revierte el orden de las fechas para tener las más recientes primero
            $rangosFechas = array_reverse($rangosFechas);

            try {
                // Sumar los dos ultimos valores de los dos array (por mercado) para ventas semanales
                $ultimaSumaArray1 = end($ventas[0]);
                $ultimaSumaArray2 = end($ventas[1]);
                $ventasSemanales = $ultimaSumaArray1 + $ultimaSumaArray2;

                //return response()->json([$cultivos, $mercados, $rangosFechas, $ventas, $ventasSemanales]);
                return view('inventarioSemillas.estadisticas', compact('cultivos', 'mercados', 'rangosFechas', 'ventas', 'ventasSemanales'));
            } catch (\Throwable $th) {
                $ventasSemanales = 0;
                return view('inventarioSemillas.estadisticas', compact('cultivos', 'mercados', 'rangosFechas', 'ventas', 'ventasSemanales'));
            }
        } else{
            return view('dashboard');
        }
    }

    //Consulta de los ultimos 12 meses
    public function estadisticas_12meses(Request $request, $id) {
        $userId = $request->user()->id;

        // Verifica si el rol del usuario es'Administrador'
        if (DB::table('users')->where('id', $userId)->where('tipoUsuario', 'Administrador')) {
            // Obtener registros del modelo Cultivo
            $cultivos = Cultivo::where('id', $id)->get();
            // Obtener registros del modelo Mercado
            $mercados = Mercado::all();

            // Configura Carbon en español
            Carbon::setLocale('es');
            // Obtiene la fecha de hoy
            $today = Carbon::now();
            // Inicializa un array para almacenar los rangos de fechas y la informacion de las ventas
            $rangosFechas = [];
            $ventas = [];

            foreach ($mercados as $mercado) {
                $ventasMercado = [];
            
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
                        ->join('mercados', 'mercados.id', '=', 'ventas_cultivos.mercado_id')
                        ->where('ventas_cultivos.cultivo_id', '=', $id)
                        ->where('ventas_cultivos.mercado_id', '=', $mercado->id) // Filtra por el mercado actual
                        ->whereDate('ventas_cultivos.fecha', '>=', $startOfMonth)
                        ->whereDate('ventas_cultivos.fecha', '<=', $endOfMonth)
                        ->get();
            
                    $sumaMonto = $venta[0]->suma_monto ?? 0;
            
                    $ventasMercado[] = $sumaMonto;
                    $startOfMonth->subMonth();
                }
            
                // Revierte el orden de los datos de ventas para tener los más recientes primero
                $ventasMercado = array_reverse($ventasMercado);
            
                $ventas[] = $ventasMercado;
            }
            
            // Revierte el orden de las fechas para tener las más recientes primero
            $rangosFechas = array_reverse($rangosFechas);

            // Sumar los dos ultimos valores de los dos array (por mercado) para ventas semanales
            $ultimaSumaArray1 = end($ventas[0]);
            $ultimaSumaArray2 = end($ventas[1]);
            $ventasMensuales = $ultimaSumaArray1 + $ultimaSumaArray2;

        return response()->json([$cultivos, $mercados, $rangosFechas, $ventas, $ventasMensuales]);
        } else{
            return response()->json(null);
        }
    }

    //Consulta de un rango de fechas (fecha inicial y fecha final) establecida por el usuario
    public function estadisticas_rangos(Request $request, $id, $fechaInicio, $fechaFin) {
        $userId = $request->user()->id;
    
        // Verifica si el rol del usuario es 'Administrador'
        if (DB::table('users')->where('id', $userId)->where('tipoUsuario', 'Administrador')) {
            // Obtener registros del modelo Cultivo
            $cultivos = Cultivo::where('id', $id)->get();
            // Obtener registros del modelo Mercado
            $mercados = Mercado::all();
    
            // Configura Carbon en español
            Carbon::setLocale('es');
    
            $fechaInicio = Carbon::parse($fechaInicio);
            $fechaFin = Carbon::parse($fechaFin);
    
            // Inicializa un array para almacenar los rangos de fechas y la información de las ventas
            $rangosFechas = [];
            $ventas = [];
    
            foreach ($mercados as $mercado) {
                $ventasMercado = [];
            
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
                        ->join('mercados', 'mercados.id', '=', 'ventas_cultivos.mercado_id')
                        ->where('ventas_cultivos.cultivo_id', '=', $id)
                        ->where('ventas_cultivos.mercado_id', '=', $mercado->id)
                        ->whereDate('ventas_cultivos.fecha', '>=', $parteInicio)
                        ->whereDate('ventas_cultivos.fecha', '<', $parteFin)
                        ->get();
            
                    $sumaMonto = $venta[0]->suma_monto ?? 0;
            
                    $ventasMercado[] = $sumaMonto;
                }
            
                $ventas[] = $ventasMercado;
            }
    
            return response()->json([$cultivos, $mercados, $rangosFechas, $ventas]);
        } else {
            return response()->json(null);
        }
    }
}
