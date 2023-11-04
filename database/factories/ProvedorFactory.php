<?php

namespace Database\Factories;

use App\Models\Provedor;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProvedorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Provedor::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->company,
            'telefono' => $this->faker->phoneNumber,
        ];
    }
}
