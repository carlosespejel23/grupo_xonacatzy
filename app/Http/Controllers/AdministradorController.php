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
}
