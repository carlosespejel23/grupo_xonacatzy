<?php

namespace Database\Factories;

use App\Models\Cultivo;
use Illuminate\Database\Eloquent\Factories\Factory;

class CultivoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Cultivo::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'provedor_id' => $this->faker->numberBetween(1, 10),
            'nombre' => $this->faker->unique()->randomElement([
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
