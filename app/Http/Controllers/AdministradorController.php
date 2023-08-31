<?php

namespace App\Http\Controllers;

use App\Models\Cultivo;
use App\Models\Producto;
use App\Models\Provedor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

//Controlador de todas la acciones del administrador
class AdministradorController extends Controller
{
    //Renderiza el panel principal del administrador
    public function index(Request $request) {
        $userId = $request->user()->id;

        // Verifica si el rol del usuario es'Administrador'
        if (DB::table('users')->where('id', $userId)->where('tipoUsuario', 'Administrador')) {
            return view('administrador.admin');
        } else {
            return view('dashboard');
        }
    }

    //Rederiza la seccion de ventas
    public function ventas(Request $request) {
        $userId = $request->user()->id;

        // Verifica si el rol del usuario es'Administrador'
        if (DB::table('users')->where('id', $userId)->where('tipoUsuario', 'Administrador')) {
            return view('administrador.ventas');
        } else {
            return view('dashboard');
        }
    }

    //Rederiza la seccion de usuarios
    public function usuarios(Request $request) {
        $userId = $request->user()->id;
        $usuarios = User::all();

        // Verifica si el rol del usuario es'Administrador'
        if (DB::table('users')->where('id', $userId)->where('tipoUsuario', 'Administrador')) {
            return view('administrador.usuarios', compact('usuarios'));
        } else {
            return view('dashboard');
        }
    }

    //Elimina un usuario
    public function usuario_delete($id) {
        $usuario = User::find($id);
        $usuario->delete();

        session()->flash('flash.banner', 'El usuario se ha eliminado correctamente');
        session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('administrador.usuarios');
    }

    //Rederiza la seccion de cultivos
    public function cultivos(Request $request) {
        $userId = $request->user()->id;
        $provedores = Provedor::all();
        $cultivos = Cultivo::all();

        // Verifica si el rol del usuario es'Administrador'
        if (DB::table('users')->where('id', $userId)->where('tipoUsuario', 'Administrador')) {
            return view('administrador.cultivos', compact('provedores', 'cultivos'));
        } else {
            return view('dashboard');
        }
    }

    //Crear un cultivo
    public function cultivo_create(Request $request) {
        $validated = $request->validate([
            'provedor_id' => 'required',
            'nombre' => 'required',
            'nombre_tecnico' => 'nullable',
            'fecha_ingreso' => 'required|date',
            'cantidad' => 'required|numeric',
        ]);

        // Crear una nueva instancia del modelo Cultivo
        $cultivo = new Cultivo;
        $cultivo->provedor_id = $request->provedor_id;
        $cultivo->nombre = $request->nombre;
        $cultivo->nombre_tecnico = $request->nombre_tecnico;
        $cultivo->fecha_ingreso = $request->fecha_ingreso;
        $cultivo->cantidad = $request->cantidad;

        $cultivo->save();

        session()->flash('flash.banner', 'El cultivo se ha creado correctamente');
        session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('administrador.cultivos');
    }

    //Actualiza un cultivo
    public function cultivo_update(Request $request, $id) {
        try {
            $validated = $request->validate([
                'provedor_id' => 'required',
                'nombre' => 'required',
                'nombre_tecnico' => 'nullable',
                'fecha_ingreso' => 'required|date',
                'cantidad' => 'required|numeric',
            ]);
    
            DB::table('cultivos')->where('id', $id)->update([
                'provedor_id' => $request->provedor_id,
                'nombre' => $request->nombre,
                'nombre_tecnico' => $request->nombre_tecnico,
                'fecha_ingreso' => $request->fecha_ingreso,
                'cantidad' => $request->cantidad,
            ]);
    
            session()->flash('flash.banner', 'El cultivo se ha actualizado correctamente');
            session()->flash('flash.bannerStyle', 'success');
    
            return redirect()->route('administrador.cultivos');
        } catch (\Throwable $th) {
            session()->flash('flash.banner', 'No puede actualizar el cultivo porque esta registrado en el Inventario de Semillas');
            session()->flash('flash.bannerStyle', 'danger');

            return redirect()->route('administrador.cultivos');
        }
    }

    //Elimina un cultivo
    public function cultivo_delete($id) {
        $cultivo = DB::table('cultivos')->where('id', $id);

        try {
            $cultivo->delete();

            session()->flash('flash.banner', 'El cultivo se ha eliminado correctamente');
            session()->flash('flash.bannerStyle', 'success');

            return redirect()->route('administrador.cultivos');
        } catch (\Throwable $th) {
            session()->flash('flash.banner', 'No puede eliminar el cultivo porque esta registrado en otras secciones');
            session()->flash('flash.bannerStyle', 'danger');

            return redirect()->route('administrador.cultivos');
        }
    }

    //Rederiza la seccion de productos
    public function productos(Request $request) {
        $userId = $request->user()->id;
        $productos = Producto::all();

        // Verifica si el rol del usuario es'Administrador'
        if (DB::table('users')->where('id', $userId)->where('tipoUsuario', 'Administrador')) {
            return view('administrador.productos', compact('productos'));
        } else {
            return view('dashboard');
        }
    }

    //Crear un producto
    public function producto_create(Request $request) {
        $validated = $request->validate([
            'nombre' => 'required',
            'precio' => 'required|numeric',
        ]);

        // Crear una nueva instancia del modelo Producto
        $producto = new Producto;
        $producto->nombre = $request->nombre;
        $producto->precio = $request->precio;

        $producto->save();

        session()->flash('flash.banner', 'El producto se ha creado correctamente');
        session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('administrador.productos');
    }

    //Actualizar un producto
    public function producto_update(Request $request, $id) {
        $validated = $request->validate([
            'nombre' => 'required',
            'precio' => 'required|numeric',
        ]);

        DB::table('productos')->where('id', $id)->update([
            'nombre' => $request->nombre,
            'precio' => $request->precio,
        ]);

        session()->flash('flash.banner', 'El producto se ha actualizado correctamente');
        session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('administrador.productos');
    }

    //Eliminar un producto
    public function producto_delete($id) {
        $producto = DB::table('productos')->where('id', $id);
        try {
            $producto->delete();

            session()->flash('flash.banner', 'El producto se ha eliminado correctamente');
            session()->flash('flash.bannerStyle', 'success');

            return redirect()->route('administrador.productos');
        } catch (\Throwable $th) {
            session()->flash('flash.banner', 'No puede eliminar el producto porque esta registrado en las ventas');
            session()->flash('flash.bannerStyle', 'danger');

            return redirect()->route('administrador.productos');
        }
    }

    //Rederiza la seccion de provedores
    public function provedor(Request $request) {
        $userId = $request->user()->id;
        $provedores = Provedor::all();

        // Verifica si el rol del usuario es'Administrador'
        if (DB::table('users')->where('id', $userId)->where('tipoUsuario', 'Administrador')) {
            return view('administrador.provedores', compact('provedores'));
        } else {
            return view('dashboard');
        }
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

        return redirect()->route('administrador.provedor');
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

        return redirect()->route('administrador.provedor');
    }

    //Elimina un provedor
    public function provedor_delete($id) {
        $provedor = DB::table('provedores')->where('id', $id);
        try {
            $provedor->delete();

            session()->flash('flash.banner', 'El provedor se ha eliminado correctamente');
            session()->flash('flash.bannerStyle', 'success');

            return redirect()->route('administrador.provedor');
        } catch (\Throwable $th) {
            session()->flash('flash.banner', 'No puede eliminar el provedor porque esta registrado en los cultivos');
            session()->flash('flash.bannerStyle', 'danger');

            return redirect()->route('administrador.provedor');
        }
    }
}
