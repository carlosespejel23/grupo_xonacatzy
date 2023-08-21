<?php

namespace App\Http\Controllers;

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

    //Rederiza la seccion de cultivos
    public function cultivos(Request $request) {
        $userId = $request->user()->id;

        // Verifica si el rol del usuario es'Administrador'
        if (DB::table('users')->where('id', $userId)->where('tipoUsuario', 'Administrador')) {
            return view('administrador.cultivos');
        } else {
            return view('dashboard');
        }
    }

    //Rederiza la seccion de productos
    public function productos(Request $request) {
        $userId = $request->user()->id;

        // Verifica si el rol del usuario es'Administrador'
        if (DB::table('users')->where('id', $userId)->where('tipoUsuario', 'Administrador')) {
            return view('administrador.productos');
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

    //Elimina un usuario
    public function usuario_delete($id) {
        $usuario = User::find($id);
        $usuario->delete();

        session()->flash('flash.banner', 'El usuario se ha eliminado correctamente');
        session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('administrador.usuarios');
    }
}
