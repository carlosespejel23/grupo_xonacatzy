<?php

namespace Database\Factories;

use App\Models\Registro;
use Illuminate\Database\Eloquent\Factories\Factory;

class RegistroFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Registro::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'provedor_id' => $this->faker->numberBetween(1, 10),
            'cultivo_id' => $this->faker->numberBetween(1, 25),
            'fecha_salida' => $this->faker->dateTimeBetween('2023-10-01', '2023-12-31')->format('Y-m-d'),
            'cantidad' => $this->faker->numberBetween(50, 2000),
            'destino' => $this->faker->randomElement([
                'Invernadero 1',
                'Invernadero 2',
                'Campo de cultivo 1',
                'Campo de cultivo 2',
            ]),
            'encargado' => $this->faker->firstName(),
            'responsable' => $this->faker->firstName(),
        ];
    }
}
