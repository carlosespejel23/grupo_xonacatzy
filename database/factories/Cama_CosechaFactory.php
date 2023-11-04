<?php

namespace Database\Factories;

use App\Models\Cama_Cosecha;
use Illuminate\Database\Eloquent\Factories\Factory;

class Cama_CosechaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Cama_Cosecha::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cosecha_id' => $this->faker->numberBetween(1, 1500),
            'num_cama' => $this->faker->numberBetween(1, 20),
        ];
    }
}
