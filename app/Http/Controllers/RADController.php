<?php

namespace App\Http\Controllers;

use App\Models\Cama_Cosecha;
use App\Models\Combinado;
use App\Models\Cosecha;
use App\Models\Cultivo;
use App\Models\Tarea_Diaria;
use App\Models\Empaque;
use App\Models\User;
use DateTimeZone;
use DragonCode\Contracts\Cashier\Auth\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Nette\Utils\DateTime;

//Controlador de la seccion "Reportes de Actividades Diarias (RAD)"
class RADController extends Controller
{
    //Renderiza la vista de reportes de actividades diarias
    public function index() {
        //Extrae la hora actual
        $zonaHoraria = new DateTimeZone('America/Mexico_City');
        $fechaActual = new DateTime('now', $zonaHoraria);
        $fechaActualStr = $fechaActual->format('Y-m-d');

        //Consulta a la tabla cosechas
        $cosechas = DB::table('cosechas')
            ->select(
                'cosechas.id',
                'cultivos.nombre',
                'cosechas.num_botes',
                'cosechas.invernadero',
                'cosechas.corte',
                'cosechas.encargado',
                'cosechas.fecha',
                DB::raw('(SELECT GROUP_CONCAT(num_cama) FROM camas_cosechas WHERE camas_cosechas.cosecha_id = cosechas.id) as num_cama')
            )
            ->join('cultivos', 'cultivos.id', '=', 'cosechas.cultivo_id')
            ->whereDate('cosechas.fecha', '=', $fechaActualStr)
            ->orderBy('cosechas.created_at', 'asc')
            ->get();

        //Consulta a la tabla empaques y combinados
        $empaques = DB::table('empaques')
            ->select(
                'empaques.id',
                'cultivos.nombre',
                DB::raw('COALESCE(CONCAT(empaques.num_bolsas, ", ", (SELECT MAX(combinados.num_bolsas) FROM combinados WHERE combinados.cultivo_id = empaques.cultivo_id)), empaques.num_bolsas) as num_bolsas'),
                DB::raw('COALESCE(CONCAT(empaques.gramos, ", ", (SELECT MAX(combinados.gramos) FROM combinados WHERE combinados.cultivo_id = empaques.cultivo_id)), empaques.gramos) as gramos'),
                'empaques.temp_inicial',
                'empaques.temp_final',
                'empaques.H2O',
            )
            ->join('cultivos', 'cultivos.id', '=', 'empaques.cultivo_id')
            ->whereDate('empaques.fecha', '=', $fechaActualStr)
            ->orderBy('empaques.created_at', 'asc')
            ->get();
        
        //Consulta a la tabla tareas_diarias
        $tareas = DB::table('tareas_diarias')
            ->select(
                'tareas_diarias.id',
                'tareas_diarias.nombre',
            )
            ->whereDate('tareas_diarias.fecha', '=', $fechaActualStr)
            ->orderBy('tareas_diarias.created_at', 'asc')
            ->get();

        //Consulta a los cultivos
        $cultivos = Cultivo::orderBy('nombre', 'asc')->get();

        return view('dashboard', compact('cultivos', 'cosechas', 'tareas', 'empaques'));
    }

    //Crea un registro en la tabla "Cosechas" y tambien en "Empaques"
    public function cosecha_create(Request $request) {
        $validated = $request->validate([
            'cultivo_id' => 'required',
            'num_botes' => 'required|numeric',
            'invernadero' => 'nullable|numeric',
            'corte' => 'nullable|numeric',
            'fecha' => 'required|date',
            'num_cama.*' => 'nullable|numeric',
        ]);
    
        // Crear una nueva instancia del modelo Cosecha
        $cosecha = new Cosecha;
        $cosecha->cultivo_id = $request->cultivo_id;
        $cosecha->num_botes = $request->num_botes;
        $cosecha->invernadero = $request->invernadero;
        $cosecha->corte = $request->corte;
        $cosecha->encargado = auth()->user()->nombre;
        $cosecha->fecha = $request->fecha;
    
        // Guardar el modelo, lo que automáticamente establecerá los timestamps
        $cosecha->save();
    
        // Obtener el array de números de cama
        $numCamas = $request->input('num_cama');
    
        // Insertar cada número de cama en la tabla CamasCosecha
        foreach ($numCamas as $numCama) {
            $camasCosecha = new Cama_Cosecha;
            $camasCosecha->cosecha_id = $cosecha->id;
            $camasCosecha->num_cama = $numCama;
            $camasCosecha->save();
        }

        // Crear una nueva instancia del modelo Empaque
        $empaque = new Empaque;
        $empaque->cultivo_id = $request->cultivo_id;
        $empaque->fecha = $request->fecha;
        $empaque->save();
    
        session()->flash('flash.banner', 'El registro se ha creado correctamente');
        session()->flash('flash.bannerStyle', 'success');
    
        return redirect()->route('dashboard');
    }
     
    //Consulta los registros del input "Consultar Registros"
    public function cosecha_consultar($fecha) {
        $cosechas = DB::table('cosechas')
            ->select(
                'cosechas.id',
                'cultivos.nombre',
                'cosechas.num_botes',
                'cosechas.invernadero',
                'cosechas.corte',
                'cosechas.encargado',
                'cosechas.fecha',
                DB::raw('(SELECT GROUP_CONCAT(num_cama) FROM camas_cosechas WHERE camas_cosechas.cosecha_id = cosechas.id) as num_cama')
            )
            ->join('cultivos', 'cultivos.id', '=', 'cosechas.cultivo_id')
            ->whereDate('cosechas.fecha', '=', $fecha)
            ->orderBy('cosechas.created_at', 'asc')
            ->get();

        //Consulta a la tabla empaques
        $empaques = DB::table('empaques')
            ->select(
                'empaques.id',
                'cultivos.nombre',
                //AND combinados.fecha = empaques.fecha
                DB::raw('COALESCE(CONCAT(empaques.num_bolsas, ", ", (SELECT MAX(combinados.num_bolsas) FROM combinados WHERE combinados.cultivo_id = empaques.cultivo_id AND combinados.fecha = empaques.fecha)), empaques.num_bolsas) as num_bolsas'),
                DB::raw('COALESCE(CONCAT(empaques.gramos, ", ", (SELECT MAX(combinados.gramos) FROM combinados WHERE combinados.cultivo_id = empaques.cultivo_id AND combinados.fecha = empaques.fecha)), empaques.gramos) as gramos'),
                'empaques.temp_inicial',
                'empaques.temp_final',
                'empaques.H2O',
            )
            ->join('cultivos', 'cultivos.id', '=', 'empaques.cultivo_id')
            ->whereDate('empaques.fecha', '=', $fecha)
            ->orderBy('empaques.created_at', 'asc')
            ->get();

        // Consulta de tareas diarias
        $tareas = DB::table('tareas_diarias')
            ->select(
                'tareas_diarias.nombre'
            )
            ->whereDate('tareas_diarias.fecha', '=', $fecha)
            ->orderBy('tareas_diarias.created_at', 'asc')
            ->get();

        $cultivos = Cultivo::all();

        return response()->json([
            'cosechas' => $cosechas,
            'tareas_diarias' => $tareas,
            'empaques' => $empaques,
        ]);
    }

    //Crear un registro en la lista de tareas diarias
    public function tareas_create(Request $request) {
        $zonaHoraria = new DateTimeZone('America/Mexico_City');
        $fechaActual = new DateTime('now', $zonaHoraria);
        $fechaActualStr = $fechaActual->format('Y-m-d');

        $validated = $request->validate([
            'nombre' => 'required',
        ]);
    
        // Crear una nueva instancia del modelo Tarea Diaria
        $tarea = new Tarea_Diaria();
        $tarea->nombre = $request->nombre;
        $tarea->fecha = $fechaActualStr;
    
        // Guardar el modelo, lo que automáticamente establecerá los timestamps
        $tarea->save();
    
        session()->flash('flash.banner', 'El registro se ha creado correctamente');
        session()->flash('flash.bannerStyle', 'success');
    
        return redirect()->route('dashboard');
    }

    //Actualiza los registros de la tabla empaques
    public function empaques_update(Request $request, $id) {
        $validated = $request->validate([
            'num_bolsas' => 'nullable|numeric',
            'gramos' => 'nullable|numeric',
            'temp_inicial' => 'nullable|numeric',
            'temp_final' => 'nullable|numeric',
            'H2O' => 'nullable|numeric',
        ]);

        DB::table('empaques')->where('id', $id)->update([
            'num_bolsas' => $request->num_bolsas,
            'gramos' => $request->gramos,
            'temp_inicial' => $request->temp_inicial,
            'temp_final' => $request->temp_final,
            'H2O' => $request->H2O,
        ]);
    
        session()->flash('flash.banner', 'El registro se ha actualizado correctamente');
        session()->flash('flash.bannerStyle', 'success');
    
        return redirect()->route('dashboard');
    }

    //Crear un registro de combinados
    public function combinados_create(Request $request) {
        $zonaHoraria = new DateTimeZone('America/Mexico_City');
        $fechaActual = new DateTime('now', $zonaHoraria);
        $fechaActualStr = $fechaActual->format('Y-m-d');

        $validated = $request->validate([
            'cultivo_id' => 'required',
            'num_bolsas' => 'required|numeric',
            'gramos' => 'required|numeric',
        ]);

        // Comprobar si ya existe un combinado con el mismo cultivo_id y fecha
        $combinadoExistente = Combinado::where('cultivo_id', $request->cultivo_id)
            ->where('fecha', $fechaActualStr)
            ->first();

        if ($combinadoExistente) {
            // Si ya existe un combinado, muestra un mensaje de error y no guarda nada
            session()->flash('flash.banner', 'El combinado no se puede registrar porque ya existe');
            session()->flash('flash.bannerStyle', 'danger');
        
            return redirect()->route('dashboard');
        }
    
        // Crear una nueva instancia del modelo Combinado
        $combinado = new Combinado();
        $combinado->cultivo_id = $request->cultivo_id;
        $combinado->num_bolsas = $request->num_bolsas;
        $combinado->gramos = $request->gramos;
        $combinado->fecha = $fechaActualStr;
    
        // Guardar el modelo, lo que automáticamente establecerá los timestamps
        $combinado->save();
    
        session()->flash('flash.banner', 'El combinado se ha creado correctamente');
        session()->flash('flash.bannerStyle', 'success');
    
        return redirect()->route('dashboard');
    }

    //Elimina los registros de una fila (cosechas, empaques y combinados)
    public function delete(Request $request, $id) {
        $userId = $request->user()->id;

        // Verifica si el rol del usuario es'Administrador'
        if (DB::table('users')->where('id', $userId)->where('tipoUsuario', 'Administrador')) {
            //Elimina el registro de la tabla "Cosechas"
            $cosecha = Cosecha::find($id);
            $cosecha->delete();

            //Elimina el registro de la tabla "Empaques"
            $empaque = Empaque::find($id);
            $empaque->delete();

            //Elimina el registro de la tabla "Combinados"
            $combinado = Combinado::find($id);
            if($combinado !== null){
                $combinado->delete();
            }

            session()->flash('flash.banner', 'El registro se ha eliminado correctamente');
            session()->flash('flash.bannerStyle', 'success');
        
            return redirect()->route('dashboard');
        } else {
            return view('dashboard');
        }
    }

    //Elimina una tarea
    public function tarea_delete(Request $request, $id) {
        $userId = $request->user()->id;

        // Verifica si el rol del usuario es'Administrador'
        if (DB::table('users')->where('id', $userId)->where('tipoUsuario', 'Administrador')) {
            //Elimina el registro de la tabla "Tareas Diarias"
            $tarea = Tarea_Diaria::find($id);
            $tarea->delete();

            session()->flash('flash.banner', 'La tarea se ha eliminado correctamente');
            session()->flash('flash.bannerStyle', 'success');
        
            return redirect()->route('dashboard');
        } else {
            return view('dashboard');
        }
    }
}
