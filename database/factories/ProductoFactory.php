<?php

namespace Database\Factories;

use App\Models\Producto;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Producto::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->unique()->randomElement([
                'Fertilizante',
                'Insecticida',
                '1kg Huevo',
                '1kg Huevo Criollo',
                'Bolsas Promocionales',
            ]),
            'precio' => $this->faker->randomFloat(2, 10, 500)
        ];
    }
}
