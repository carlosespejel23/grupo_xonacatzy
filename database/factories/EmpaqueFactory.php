<?php

namespace Database\Factories;

use App\Models\Empaque;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmpaqueFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Empaque::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cultivo_id' => $this->faker->numberBetween(1, 25),
            'num_bolsas' => $this->faker->numberBetween(1, 30),
            'gramos' => $this->faker->numberBetween(1, 2000),
            'temp_inicial' => $this->faker->randomFloat(2, 10, 40),
            'temp_final' => $this->faker->randomFloat(2, 10, 40),
            'H2O' => $this->faker->randomFloat(2, 10, 500),
            'fecha' => $this->faker->dateTimeBetween('2023-10-01', '2023-12-31')->format('Y-m-d'),
        ];
    }
}
