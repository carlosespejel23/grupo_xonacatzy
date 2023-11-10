<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cultivo;
use App\Models\Mercado;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

// Controlador de las estadisticas de empaquetado de cada semilla en la seccion "Inventario de Semillas"
class EmpaqueEstadisticaController extends Controller
{
    //Renderiza la vista de Estadisticas del Cultivo
    public function empaque_estadisticas_index(Request $request, $id) {
        $userId = $request->user()->id;

        // Verifica si el rol del usuario es'Administrador'
        if (DB::table('users')->where('id', $userId)->where('tipoUsuario', 'Administrador')) {
            // Obtener registros del modelo Cultivo
            $cultivos = Cultivo::where('id', $id)->get();

            // Configura Carbon en español
            Carbon::setLocale('es');
            // Obtiene la fecha de hoy
            $today = Carbon::now();
            // Inicializa un array para almacenar los rangos de fechas y la informacion de los empaques
            $rangosFechas = [];
            $empaques = [];

            $empaquesMercado = [];
        
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
                
                // Modifica la consulta para obtener toda la suma de empaquesl
                $empaque = DB::table('empaques')
                    ->select(
                        DB::raw('SUM(empaques.num_bolsas) as suma_monto')
                    )
                    ->join('cultivos', 'cultivos.id', '=', 'empaques.cultivo_id')
                    ->where('empaques.cultivo_id', '=', $id)
                    ->whereDate('empaques.fecha', '>=', $startOfWeek)
                    ->whereDate('empaques.fecha', '<=', $endOfWeek)
                    ->get();

                $suma = $empaque[0]->suma_monto ?? 0;
        
                $empaquesMercado[] = $suma;
                $today->subWeek();
            }
        
            // Revierte el orden de los datos de empaques para tener los más recientes primero
            $empaquesMercado = array_reverse($empaquesMercado);
        
            $empaques[] = $empaquesMercado;
            
            // Revierte el orden de las fechas para tener las más recientes primero
            $rangosFechas = array_reverse($rangosFechas);

            try {
                $empaquesSemanales = end($empaques[0]);

                //return response()->json([$cultivos, $rangosFechas, $empaques, $empaquesSemanales]);
                return view('inventarioSemillas.estadisticas-empaque', compact('cultivos', 'rangosFechas', 'empaques', 'empaquesSemanales'));
            } catch (\Throwable $th) {
                $ventasSemanales = 0;
                return view('inventarioSemillas.estadisticas-empaque', compact('cultivos', 'rangosFechas', 'empaques', 'empaquesSemanales'));
            }
        } else{
            return view('dashboard');
        }
    }

    //Consulta de los ultimos 12 meses
    public function empaque_estadisticas_12meses(Request $request, $id) {
        $userId = $request->user()->id;

        // Verifica si el rol del usuario es'Administrador'
        if (DB::table('users')->where('id', $userId)->where('tipoUsuario', 'Administrador')) {
            // Obtener registros del modelo Cultivo
            $cultivos = Cultivo::where('id', $id)->get();

            // Configura Carbon en español
            Carbon::setLocale('es');
            // Obtiene la fecha de hoy
            $today = Carbon::now();
            // Inicializa un array para almacenar los rangos de fechas y la informacion de las empaques
            $rangosFechas = [];
            $empaques = [];

            $empaquesMercado = [];
        
            $today = Carbon::now(); // Reinicializa la fecha de hoy para cada mercado
            $startOfMonth = $today->copy()->startOfMonth(); // Inicializa al primer día del mes actual
        
            for ($i = 0; $i < 12; $i++) {
                $endOfMonth = $startOfMonth->copy()->endOfMonth();
                $fechaInicio = $startOfMonth->format('M');
                $fechaActual = $fechaInicio;
                $rangosFechas[] = $fechaActual;
                
                // Modifica la consulta para obtener toda la suma de empaquesl
                $empaque = DB::table('empaques')
                    ->select(
                        DB::raw('SUM(empaques.num_bolsas) as suma_monto')
                    )
                    ->join('cultivos', 'cultivos.id', '=', 'empaques.cultivo_id')
                    ->where('empaques.cultivo_id', '=', $id)
                    ->whereDate('empaques.fecha', '>=', $startOfMonth)
                    ->whereDate('empaques.fecha', '<=', $endOfMonth)
                    ->get();
        
                $suma = $empaque[0]->suma_monto ?? 0;
        
                $empaquesMercado[] = $suma;
                $startOfMonth->subMonth();
            }
        
            // Revierte el orden de los datos de empaques para tener los más recientes primero
            $empaquesMercado = array_reverse($empaquesMercado);
        
            $empaques[] = $empaquesMercado;
            
            // Revierte el orden de las fechas para tener las más recientes primero
            $rangosFechas = array_reverse($rangosFechas);

            $empaquesMensuales = end($empaques[0]);

        return response()->json([$cultivos, $rangosFechas, $empaques, $empaquesMensuales]);
        } else{
            return response()->json(null);
        }
    }

    //Consulta de un rango de fechas (fecha inicial y fecha final) establecida por el usuario
    public function empaque_estadisticas_rangos(Request $request, $id, $fechaInicio, $fechaFin) {
        $userId = $request->user()->id;
    
        // Verifica si el rol del usuario es 'Administrador'
        if (DB::table('users')->where('id', $userId)->where('tipoUsuario', 'Administrador')) {
            // Obtener registros del modelo Cultivo
            $cultivos = Cultivo::where('id', $id)->get();
    
            // Configura Carbon en español
            Carbon::setLocale('es');
    
            $fechaInicio = Carbon::parse($fechaInicio);
            $fechaFin = Carbon::parse($fechaFin);
    
            // Inicializa un array para almacenar los rangos de fechas y la información de las$empaques
            $rangosFechas = [];
            $empaques = [];

            $empaquesMercado = [];
        
            for ($fechaActual = $fechaInicio->copy(); $fechaActual->lte($fechaFin); $fechaActual->addMonth()) {
                $parteInicio = $fechaActual->copy();
                $parteFin = $fechaActual->copy()->addMonth();
        
                $fechaInicioFormateada = $parteInicio->format('d/M/y');
                $fechaFinFormateada = $parteFin->format('d/M/y');
                $fechaActualStr = "$fechaInicioFormateada - $fechaFinFormateada";
                $rangosFechas[] = $fechaActualStr;
        
                // Modifica la consulta para obtener toda la suma de empaquesl
                $empaque = DB::table('empaques')
                    ->select(
                        DB::raw('SUM(empaques.num_bolsas) as suma_monto')
                    )
                    ->join('cultivos', 'cultivos.id', '=', 'empaques.cultivo_id')
                    ->where('empaques.cultivo_id', '=', $id)
                    ->whereDate('empaques.fecha', '>=', $parteInicio)
                    ->whereDate('empaques.fecha', '<=', $parteFin)
                    ->get();
        
                $suma = $empaque[0]->suma_monto ?? 0;
        
                $empaquesMercado[] = $suma;
            }

            $empaques[] = $empaquesMercado;
    
            return response()->json([$cultivos, $rangosFechas, $empaques]);
        } else {
            return response()->json(null);
        }
    }
}
