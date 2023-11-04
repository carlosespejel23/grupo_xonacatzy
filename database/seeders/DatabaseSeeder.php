<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seeder para usuarios
        \App\Models\User::factory(10)->create();

        // Seeder para proveedores
        \App\Models\Provedor::factory(10)->create();

        // Seeder para semillas
        \App\Models\Cultivo::factory(25)->create();

        // Seeder para productos
        \App\Models\Producto::factory(5)->create();

        // Seeder para mercados
        \App\Models\Mercado::factory(2)->create();

        // Seeder para Cultivos Historial
        \App\Models\Cultivo_Historial::factory(60)->create();

        // Seeder para registros de salida de la semilla
        \App\Models\Registro::factory(100)->create();

        //Seeder para cosechas
        \App\Models\Cosecha::factory(1500)->create();

        // Seeder para camas cosechas
        \App\Models\Cama_Cosecha::factory(2500)->create();

        // Seeder para empaques
        \App\Models\Empaque::factory(1500)->create();

        // Seeder para combinados
        \App\Models\Combinado::factory(1000)->create();

        // Seeder para tareas diarias
        \App\Models\Tarea_Diaria::factory(200)->create();

        // Seeder para ventas de cultivos
        \App\Models\Venta_Cultivo::factory(2000)->create();

        // Seeder para ventas de productos
        \App\Models\Venta_Producto::factory(1500)->create();

        // Seeder para gastos extra
        \App\Models\Gasto_Extra::factory(500)->create();
    }
}
