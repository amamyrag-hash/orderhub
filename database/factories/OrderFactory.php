<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_id'=> Customer::factory(),
            'status'=> fake()->randomElement(['draft','pending','invoiced' , 'paid' , 'shipped' , 'canceled']),
            'total_amount'=> 0,
        ];
    }
    public function draft(): static
    {
        return $this->state(fn () =>['status'=>'draft']);
    }

    
    public function pending(): static
    {
        return $this->state(fn () => ['status' => 'pending']);
    }

    public function invoiced(): static
    {
        return $this->state(fn () => ['status'=> 'invoiced']);
    }

    public function paid(): static
    {
        return $this->state(fn () => ['status' => 'paid']);
    }

    public function shipped(): static
    {
        return $this->state(fn () => ['status' => 'shipped']);
    }

    public function canceled(): static
    {
        return $this->state(fn () => ['status' => 'canceled']);
    }

    public function withItems(int $count = 3): static
    {
        return $this->afterCreating(function ($order) use ($count) {
            $products = Product::inRandomOrder()->limit($count)->get();

            if ($products->count() < $count) {
                $products = $products->concat(
                    Product::factory()->count($count - $products->count())->create()
                );
            }

            $total = 0;

            foreach ($products as $product) {
                $quantity = fake()->numberBetween(1, 5);

                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $product->id,
                    'quantity'   => $quantity,
                    'unit_price' => $product->price,
                ]);

                $total += $quantity * $product->price;
            }

            $order->update(['total_amount' => $total]);
        });
    }
}
