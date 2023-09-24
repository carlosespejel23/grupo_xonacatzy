<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cultivo;
use App\Models\Cultivo_Historial;
use App\Models\Provedor;
use App\Models\Registro;
use Illuminate\Support\Facades\DB;

//Controlador de la seccion "Inventario de Semillas (IDS)"
class IDSController extends Controller
{
    public function index() {
       //Consulta a los cultivos
       $cultivos = Cultivo::orderBy('nombre', 'asc')->get();
       $provedores = Provedor::all();

        return view('inventarioSemillas.inventarioSemillas', compact('cultivos', 'provedores'));
    }

    //Crear una semilla
    public function semilla_create(Request $request) {
        $validated = $request->validate([
            'provedor_id' => 'required',
            'encargado' => 'required',
            'nombre' => 'required',
            'nombre_tecnico' => 'nullable',
            'fecha_ingreso' => 'required|date',
            'cantidad' => 'required|numeric',
        ]);

        // Crear una nueva instancia del modelo Cultivo
        $cultivo = new Cultivo;
        $cultivo->provedor_id = $request->provedor_id;
        $cultivo->encargado = $request->encargado;
        $cultivo->nombre = $request->nombre;
        $cultivo->nombre_tecnico = $request->nombre_tecnico;
        $cultivo->fecha_ingreso = $request->fecha_ingreso;
        $cultivo->cantidad = $request->cantidad;

        $cultivo->save();

        session()->flash('flash.banner', 'La semilla se ha creado correctamente');
        session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('inventario.index');
    }

    //Actualiza una semilla
    public function semilla_update(Request $request, $id) {
        $validated = $request->validate([
            'nombre' => 'required',
            'nombre_tecnico' => 'nullable',
        ]);

        DB::table('cultivos')->where('id', $id)->update([
            'nombre' => $request->nombre,
            'nombre_tecnico' => $request->nombre_tecnico,
        ]);

        session()->flash('flash.banner', 'La semilla se ha actualizado correctamente');
        session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('inventario.registros', $id);
    }

    //Elimina una Semilla
    public function semilla_delete($id) {
        $cultivo = DB::table('cultivos')->where('id', $id);

        try {
            $cultivo->delete();

            session()->flash('flash.banner', 'La semilla se ha eliminado correctamente');
            session()->flash('flash.bannerStyle', 'success');

            return redirect()->route('inventario.index');
        } catch (\Throwable $th) {
            session()->flash('flash.banner', 'No puede eliminar la semilla porque esta registrada en otras secciones');
            session()->flash('flash.bannerStyle', 'danger');

            return redirect()->route('inventario.index');
        }
    }

    //Rederiza la seccion de provedores
    public function provedor(Request $request) {
        $provedores = Provedor::all();
        
        return view('inventarioSemillas.provedores', compact('provedores'));
    }

    //Crear un provedor
    public function provedor_create(Request $request) {
        $validated = $request->validate([
            'nombre' => 'required',
            'telefono' => 'nullable',
        ]);

        // Crear una nueva instancia del modelo Provedor
        $provedor = new Provedor;
        $provedor->nombre = $request->nombre;
        $provedor->telefono = $request->telefono;

        $provedor->save();

        session()->flash('flash.banner', 'El provedor se ha creado correctamente');
        session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('inventario.provedor');
    }

    //Actualizar un provedor
    public function provedor_update(Request $request, $id) {
        $validated = $request->validate([
            'nombre' => 'required',
            'telefono' => 'nullable',
        ]);

        DB::table('provedores')->where('id', $id)->update([
            'nombre' => $request->nombre,
            'telefono' => $request->telefono,
        ]);

        session()->flash('flash.banner', 'El provedor se ha actualizado correctamente');
        session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('inventario.provedor');
    }

    //Elimina un provedor
    public function provedor_delete($id) {
        $provedor = DB::table('provedores')->where('id', $id);
        try {
            $provedor->delete();

            session()->flash('flash.banner', 'El proveedor se ha eliminado correctamente');
            session()->flash('flash.bannerStyle', 'success');

            return redirect()->route('administrador.provedor');
        } catch (\Throwable $th) {
            session()->flash('flash.banner', 'No puede eliminar el proveedor porque esta registrado en el inventario de semillas');
            session()->flash('flash.bannerStyle', 'danger');

            return redirect()->route('inventario.provedor');
        }
    }

    //Renderiza la vista de Registros
    public function registros($id) {
        // Obtener registros del modelo Cultivo
        $cultivos = Cultivo::where('id', $id)->get();
        // Obtener registros del modelo Cultivo_Historial
        $historiales = Cultivo_Historial::where('id', $id)->get();
        // Combina los resultados de ambas consultas en una sola colección
        $resultados = $cultivos->concat($historiales);
        $cultivos = Cultivo::where('id', '=', $id)->get();
        //$registros = Registro::where('cultivo_id', '=', $id)->get();
        $provedores = Provedor::all();

        $registros = DB::table('registros')
        ->select(
            'registros.id',
            'registros.provedor_id',
            'registros.cultivo_id',
            'registros.fecha_salida',
            'registros.cantidad',
            'registros.destino',
            'registros.responsable',
            'registros.encargado',
        )
        ->join('cultivos', 'cultivos.id', '=', 'registros.cultivo_id')
        //>join('cultivos_historial', 'cultivos_historial.id', '=', 'registros.cultivo_id')
        ->where('registros.cultivo_id', '=', $id)
        ->orderBy('registros.created_at', 'asc')
        ->get();

        return view('inventarioSemillas.registros', compact('cultivos', 'registros', 'provedores', 'resultados'));
    }

    //Crear un registro
    public function registro_create(Request $request, $id) {
        $validated = $request->validate([
            'provedor_id' => 'required',
            'fecha_salida' => 'required|date',
            'cantidad' => 'required|numeric',
            'destino' => 'required',
            'encargado' => 'required',
            'responsable' => 'required',
        ]);

        // Crear una nueva instancia del modelo Registro
        $registro = new Registro;
        $registro->cultivo_id = $id;
        $registro->provedor_id = $request->provedor_id;
        $registro->fecha_salida = $request->fecha_salida;
        $registro->cantidad = $request->cantidad;
        $registro->destino = $request->destino;
        $registro->encargado = $request->encargado;
        $registro->responsable = $request->responsable;

        $registro->save();

        session()->flash('flash.banner', 'El registro se ha creado correctamente');
        session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('inventario.registros', $registro->cultivo_id);
    }

    //Actualizar registros de la semilla
    public function registro_update(Request $request, $id) {
        $validated = $request->validate([
            'provedor_id' => 'required',
            'encargado' => 'required',
            'fecha_ingreso' => 'required|date',
            'cantidad' => 'required|numeric',
        ]);

        DB::table('cultivos')->where('id', $id)->update([
            'provedor_id' => $request->provedor_id,
            'encargado' => $request->encargado,
            'fecha_ingreso' => $request->fecha_ingreso,
            'cantidad' => $request->cantidad,
        ]);

        session()->flash('flash.banner', 'El registro se ha actualizado correctamente');
        session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('inventario.registros', $id);
    }
}
