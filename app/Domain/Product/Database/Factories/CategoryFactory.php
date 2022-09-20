<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Domain\Product\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $categories = ['insurance', 'vehicle'];
        $category = $categories[array_rand($categories)];

        return [
            'name' => $category,
            'slug' => Str::snake($category),
            'discount' => $category === 'insurance' ? '30' : null
        ];
    }
}
