<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//Controlador de la seccion "Inventario de Semillas (IDS)"
class IDSController extends Controller
{
    public function index() {
        return view('inventarioSemillas.inventarioSemillas');
    }
}
