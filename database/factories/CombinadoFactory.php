<?php

namespace Database\Factories;

use App\Models\Combinado;
use Illuminate\Database\Eloquent\Factories\Factory;

class CombinadoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Combinado::class;

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
            'fecha' => $this->faker->dateTimeBetween('2023-10-01', '2023-12-31')->format('Y-m-d'),
        ];
    }
}
