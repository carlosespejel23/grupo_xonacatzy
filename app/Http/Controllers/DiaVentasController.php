<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DiaVentasController extends Controller
{
    //Renderiza la seccion de Dia de Ventas
    public function index(Request $request) {
        $userId = $request->user()->id;

        // Verifica si el rol del usuario es'Administrador'
        if (DB::table('users')->where('id', $userId)->where('tipoUsuario', 'Administrador')) {
            return view('diaVentas.diaVentas');
        } else {
            return view('dashboard');
        }
    }
}
