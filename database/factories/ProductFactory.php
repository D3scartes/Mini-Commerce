<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            // Kalau seeder tidak “for(Category::factory())”, ini fallback:
            'category_id' => Category::factory(),
            'name'        => fake()->unique()->words(2, true),      // "Kopi Susu"
            'price'       => fake()->numberBetween(5000, 250000),   // angka utuh; cast ke decimal:2 di model
            'stock'       => fake()->numberBetween(0, 50),
            'is_active'   => true,
            'description' => fake()->optional()->sentence(12),
        ];
    }
}
