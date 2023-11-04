<?php

namespace Database\Factories;

use App\Models\Venta_Cultivo;
use Illuminate\Database\Eloquent\Factories\Factory;

class Venta_CultivoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Venta_Cultivo::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'mercado_id' => $this->faker->numberBetween(1, 2),
            'cultivo_id' => $this->faker->numberBetween(1, 25),
            'cantidad' => $this->faker->numberBetween(1, 50),
            'monto' => $this->faker->randomFloat(2, 10, 500),
            'fecha' => $this->faker->dateTimeBetween('2023-01-01', '2023-12-31')->format('Y-m-d'),
        ];
    }
}
