<?php

namespace Database\Factories;

use App\Models\Tarea_Diaria;
use Illuminate\Database\Eloquent\Factories\Factory;

class Tarea_DiariaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Tarea_Diaria::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->text(20),
            'fecha' => $this->faker->dateTimeBetween('2023-10-01', '2023-12-31')->format('Y-m-d'),
        ];
    }
}
