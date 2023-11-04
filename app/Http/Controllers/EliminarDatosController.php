<?php

namespace App\Http\Controllers;

use App\Models\Combinado;
use App\Models\Cosecha;
use App\Models\Cultivo;
use App\Models\Empaque;
use App\Models\Gasto_Extra;
use App\Models\Mercado;
use App\Models\Tarea_Diaria;
use App\Models\Venta_Cultivo;
use App\Models\Venta_Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

//Controlador de la sub-seccion del panel administrador a "Eliminar Informacion"
class EliminarDatosController extends Controller
{
     //Rederiza la seccion de Eliminacion de Informacion
     public function index(Request $request) {
        $userId = $request->user()->id;

        // Verifica si el rol del usuario es'Administrador'
        if (DB::table('users')->where('id', $userId)->where('tipoUsuario', 'Administrador')) {
            //Consulta a los cultivos
            $cultivos = Cultivo::orderBy('nombre', 'asc')->get();
            //Consulta a los proveedores
            $provedores = DB::table('provedores')->orderBy('nombre', 'asc')->get();
            //Consulta a los mercados
            $mercados = Mercado::orderBy('nombre', 'asc')->get();
            //Consulta a productos
            $productos = DB::table('productos')->orderBy('nombre', 'asc')->get();

            return view('administrador.eliminar_datos', compact('cultivos', 'provedores', 'mercados', 'productos'));
        } else {
            return view('dashboard');
        }
    }

    //Elimina un provedor
    public function provedor_delete(Request $request, $id) {
        $userId = $request->user()->id;

        // Verifica si el rol del usuario es'Administrador'
        if (DB::table('users')->where('id', $userId)->where('tipoUsuario', 'Administrador')) {
            $provedor = DB::table('provedores')->where('id', $id);
            try {
                $provedor->delete();

                session()->flash('flash.banner', 'El proveedor se ha eliminado correctamente');
                session()->flash('flash.bannerStyle', 'success');

                return redirect()->route('administrador.eliminar-datos');
            } catch (\Throwable $th) {
                session()->flash('flash.banner', 'No puede eliminar el proveedor porque esta registrado en el inventario de semillas');
                session()->flash('flash.bannerStyle', 'danger');

                return redirect()->route('administrador.eliminar-datos');
            }
        } else {
            return view('dashboard');
        }
    }

    //Elimina una Semilla
    public function semilla_delete(Request $request, $id) {
        $userId = $request->user()->id;

        // Verifica si el rol del usuario es'Administrador'
        if (DB::table('users')->where('id', $userId)->where('tipoUsuario', 'Administrador')) {
            $cultivo = DB::table('cultivos')->where('id', $id);
            try {
                $cultivo->delete();

                session()->flash('flash.banner', 'La semilla se ha eliminado correctamente');
                session()->flash('flash.bannerStyle', 'success');

                return redirect()->route('administrador.eliminar-datos');
            } catch (\Throwable $th) {
                session()->flash('flash.banner', 'No puede eliminar la semilla porque esta registrada en otras secciones');
                session()->flash('flash.bannerStyle', 'danger');

                return redirect()->route('administrador.eliminar-datos');
            }
        } else {
            return view('dashboard');
        }
    }

    //Eliminar un registro en Mercados
    public function mercado_delete(Request $request, $id) {
        $userId = $request->user()->id;

        // Verifica si el rol del usuario es'Administrador'
        if (DB::table('users')->where('id', $userId)->where('tipoUsuario', 'Administrador')) {
            $mercado = Mercado::findOrFail($id);
            try {
                $mercado->delete();

                session()->flash('flash.banner', 'El mercado se ha eliminado correctamente');
                session()->flash('flash.bannerStyle', 'success');

                return redirect()->route('administrador.eliminar-datos');
            } catch (\Throwable $th) {
                session()->flash('flash.banner', 'No puede eliminar el mercado porque esta registrado en las ventas');
                session()->flash('flash.bannerStyle', 'danger');

                return redirect()->route('administrador.eliminar-datos');
            }
        } else {
            return view('dashboard');
        }
    }

    //Eliminar un producto
    public function producto_delete(Request $request, $id) {
        $userId = $request->user()->id;

        // Verifica si el rol del usuario es'Administrador'
        if (DB::table('users')->where('id', $userId)->where('tipoUsuario', 'Administrador')) {
            $producto = DB::table('productos')->where('id', $id);
            try {
                $producto->delete();

                session()->flash('flash.banner', 'El producto se ha eliminado correctamente');
                session()->flash('flash.bannerStyle', 'success');

                return redirect()->route('administrador.eliminar-datos');
            } catch (\Throwable $th) {
                session()->flash('flash.banner', 'No puede eliminar el producto porque esta registrado en las ventas');
                session()->flash('flash.bannerStyle', 'danger');

                return redirect()->route('administrador.eliminar-datos');
            }
        } else {
            return view('dashboard');
        }
    }

    //Eliminar datos masivos a la seccion Reportes de Actividades Diarias
    public function rad_delete(Request $request) {
        $userId = $request->user()->id;

        // Verifica si el rol del usuario es'Administrador'
        if (DB::table('users')->where('id', $userId)->where('tipoUsuario', 'Administrador')) {
            $validated = $request->validate([
                'fecha1_hidden' => 'required|date',
                'fecha2_hidden' => 'required|date',
            ]);

            // Realiza la eliminación masiva de registros en cosechas
            Cosecha::where('fecha', '>=', $validated['fecha1_hidden'])
            ->where('fecha', '<=', $validated['fecha2_hidden'])
            ->delete();
            // Realiza la eliminación masiva de registros en empaques
            Empaque::where('fecha', '>=', $validated['fecha1_hidden'])
            ->where('fecha', '<=', $validated['fecha2_hidden'])
            ->delete();
            // Realiza la eliminación masiva de registros en combinados
            Combinado::where('fecha', '>=', $validated['fecha1_hidden'])
            ->where('fecha', '<=', $validated['fecha2_hidden'])
            ->delete();
            // Realiza la eliminación masiva de registros en tareas diarias
            Tarea_Diaria::where('fecha', '>=', $validated['fecha1_hidden'])
            ->where('fecha', '<=', $validated['fecha2_hidden'])
            ->delete();

            session()->flash('flash.banner', 'Los registros se han eliminado correctamente');
            session()->flash('flash.bannerStyle', 'success');

            return redirect()->route('administrador.eliminar-datos');
        } else {
            return view('dashboard');
        }
    }

    //Eliminar datos masivos a la seccion Dia de Ventas
    public function diaVentas_delete(Request $request) {
        $userId = $request->user()->id;

        // Verifica si el rol del usuario es'Administrador'
        if (DB::table('users')->where('id', $userId)->where('tipoUsuario', 'Administrador')) {
            $validated = $request->validate([
                'fecha1_hidden_ventas' => 'required|date',
                'fecha2_hidden_ventas' => 'required|date',
            ]);

            // Realiza la eliminación masiva de registros en ventas de cultivos
            Venta_Cultivo::where('fecha', '>=', $validated['fecha1_hidden_ventas'])
            ->where('fecha', '<=', $validated['fecha2_hidden_ventas'])
            ->delete();
            // Realiza la eliminación masiva de registros en ventas de productos
            Venta_Producto::where('fecha', '>=', $validated['fecha1_hidden_ventas'])
            ->where('fecha', '<=', $validated['fecha2_hidden_ventas'])
            ->delete();
            // Realiza la eliminación masiva de registros en gastos extra
            Gasto_Extra::where('fecha', '>=', $validated['fecha1_hidden_ventas'])
            ->where('fecha', '<=', $validated['fecha2_hidden_ventas'])
            ->delete();

            session()->flash('flash.banner', 'Los registros se han eliminado correctamente');
            session()->flash('flash.bannerStyle', 'success');

            return redirect()->route('administrador.eliminar-datos');
        } else {
            return view('dashboard');
        }
    }

    //Eliminar todos los registros de historial (ingreso y salida) una sola semilla
    public function registrosSemilla_delete(Request $request, $id) {
        $userId = $request->user()->id;

        // Verifica si el rol del usuario es'Administrador'
        if (DB::table('users')->where('id', $userId)->where('tipoUsuario', 'Administrador')) {
            $registrosIngreso = DB::table('cultivos_historial')->where('cultivo_id', $id);
            $registrosSalida = DB::table('registros')->where('cultivo_id', $id);

            // Recopilar los 'provedor_id' que no se deben eliminar
            $provedoresNoEliminar = DB::table('cultivos')
            ->select('provedor_id')
            ->where('id', $id)
            ->get()
            ->pluck('provedor_id')
            ->toArray();

            try {
                $registrosIngreso->delete();
                $registrosSalida->whereNotIn('provedor_id', $provedoresNoEliminar)->delete();

                session()->flash('flash.banner', 'Los registros se han eliminado correctamente');
                session()->flash('flash.bannerStyle', 'success');

                return redirect()->route('administrador.eliminar-datos');
            } catch (\Throwable $th) {
                session()->flash('flash.banner', 'No pueden eliminar los registros');
                session()->flash('flash.bannerStyle', 'danger');

                return redirect()->route('administrador.eliminar-datos');
            }
        } else {
            return view('dashboard');
        }
    }
}
