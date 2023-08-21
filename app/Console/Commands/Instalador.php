<?php

namespace App\Console\Commands;

use App\Models\Rol;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class Instalador extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gx:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Instalador incial del proyecto para agregar al administrador';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (!$this->verificar()) {
            $this->crearUsuarioAdmin();
            $this->info('El instalador se ejecutó correctamente :)');
        } else {
            $this->error('No se puede ejecutar el instalador :(');
        }
    }

    private function verificar() {
        return User::where('email', 'fidel@hotmail.com')->exists();
    }

    private function crearUsuarioAdmin() {
        return User::create([
            'nombre' => 'Fidel',
            'apPaterno' => 'Zagoya',
            'apMaterno' => 'Fernández',
            'telefono' => '1234567890',
            'email' => 'example@gmail.com',
            'tipoUsuario' => 'Administrador',
            'password' => Hash::make('123456789')
        ]);
    }
}
