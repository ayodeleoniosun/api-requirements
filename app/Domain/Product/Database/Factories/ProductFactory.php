<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Domain\Product\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->name,
            'category_id' => 1,
            'price' => fake()->numberBetween(1000000, 100000000),
            'sku' => '00000'.fake()->unique()->numberBetween(1, 9),
        ];
    }
}
