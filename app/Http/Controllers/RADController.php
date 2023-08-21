<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//Controlador de la seccion "Reportes de Actividades Diarias (RAD)"
class RADController extends Controller
{
    public function index() {
        return view('dashboard');
    }
}
