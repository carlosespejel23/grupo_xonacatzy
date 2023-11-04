<?php

namespace Database\Factories;

use App\Models\Gasto_Extra;
use Illuminate\Database\Eloquent\Factories\Factory;

class Gasto_ExtraFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Gasto_Extra::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->text(20),
            'monto' => $this->faker->randomFloat(2, 10, 100),
            'fecha' => $this->faker->dateTimeBetween('2023-01-01', '2023-12-31')->format('Y-m-d'),
        ];
    }
}
