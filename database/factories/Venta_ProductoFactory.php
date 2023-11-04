<?php

namespace Database\Factories;

use App\Models\Venta_Producto;
use Illuminate\Database\Eloquent\Factories\Factory;

class Venta_ProductoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Venta_Producto::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'mercado_id' => $this->faker->numberBetween(1, 2),
            'producto_id' => $this->faker->numberBetween(1, 5),
            'cantidad' => $this->faker->numberBetween(1, 20),
            'fecha' => $this->faker->dateTimeBetween('2023-01-01', '2023-12-31')->format('Y-m-d'),
        ];
    }
}
