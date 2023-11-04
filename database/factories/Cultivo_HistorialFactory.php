<?php

namespace Database\Factories;

use App\Models\Cultivo_Historial;
use Illuminate\Database\Eloquent\Factories\Factory;

class Cultivo_HistorialFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Cultivo_Historial::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cultivo_id' => $this->faker->numberBetween(1, 25),
            'provedor_id' => $this->faker->numberBetween(1, 10),
            'nombre' => $this->faker->randomElement([
                'Zanahoria',
                'Brócoli',
                'Calabaza',
                'Espinaca',
                'Pepino',
                'Chayote',
                'Tomate',
                'Lechuga',
                'Apio',
                'Col Rizada',
                'Coliflor',
                'Cebolla',
                'Papa',
                'Chile',
                'Cilantro',
                'Perejil',
                'Rábano',
                'Betabel',
                'Chícharo',
                'Maíz',
                'Frijol',
                'Garbanzo',
                'Lenteja',
                'Acelga',
                'Ejote',
            ]),
            'nombre_tecnico' => 'algun texto',
            'cantidad' => $this->faker->numberBetween(50, 2000),
            'fecha_ingreso' => $this->faker->dateTimeBetween('2023-10-01', '2023-12-31')->format('Y-m-d'),
            'encargado' => $this->faker->firstName(),
        ];
    }
}
