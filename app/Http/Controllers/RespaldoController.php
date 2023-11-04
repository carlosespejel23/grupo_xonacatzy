<?php

namespace App\Http\Controllers;

// Este controlador hace y decarga un respaldo de la base de datos
class RespaldoController extends Controller
{
    public function backup()
    {
        // Comando para crear un respaldo de la base de datos
        $command = 'mysqldump -u root -p grupo_xonacatzy > backup.sql';
    
        // Ejecuta el comando para crear el respaldo
        exec($command);
    
        // Ubicación del archivo de respaldo
        $backupFile = 'backup.sql';
    
        // Devuelve el archivo como descarga
        return response()->download($backupFile);
    }
    
}
