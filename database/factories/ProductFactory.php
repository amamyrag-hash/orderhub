<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
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
            'name'=> fake()->words(3 , true),
            'description'=> fake()->sentence(),
            'price'=> fake()->randomFloat(2,0,100),
            'stock'=> fake()->numberBetween(0,100),
        ];
    }

    public function outOfStock(): static
    {
        return $this->state(fn () => ['stock' => 0]);
    }

    public function withoutDescription(): static
    {
        return $this->state(fn () => ['description' => null]);
    }

    public function priced(float $price): static
    {
        return $this->state(fn () => ['price' => $price]);
    }

    public function discounted(float $percent = 20): static
    {
        return $this->state(fn (array $attrs) => [
            'price' => round($attrs['price'] * (1 - $percent / 100), 2),
        ]);
    }
}
