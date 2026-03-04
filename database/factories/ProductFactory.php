<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => $this->faker->numberBetween(1, 10),
            'name' => $this->faker->name,
            'price' => $this->faker->numberBetween(10, 100),
            'image' => $this->faker->image('public/images', 640, 480, 'food', false),
            'description' => $this->faker->text,
            'is_available' => $this->faker->boolean,
        ];
    }
}
