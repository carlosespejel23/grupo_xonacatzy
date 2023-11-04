<?php

namespace Database\Factories;

use App\Models\Mercado;
use Illuminate\Database\Eloquent\Factories\Factory;

class MercadoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Mercado::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->unique()->randomElement([
                'Alternativo de Puebla',
                'Tameme',
            ]),
        ];
    }
}
