<?php

namespace Database\Factories;

use App\Models\Cosecha;
use Illuminate\Database\Eloquent\Factories\Factory;

class CosechaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Cosecha::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cultivo_id' => $this->faker->numberBetween(1, 25),
            'num_botes' => $this->faker->numberBetween(1, 20),
            'invernadero' => $this->faker->numberBetween(1, 4),
            'corte' => $this->faker->numberBetween(1, 20),
            'encargado' => $this->faker->firstName(),
            'fecha' => $this->faker->dateTimeBetween('2023-10-01', '2023-12-31')->format('Y-m-d'),
        ];
    }
}
