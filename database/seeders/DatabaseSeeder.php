<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Product::factory(15)->create();
        Product::factory(3)->outOfStock()->create();
        Product::factory(3)->discounted(30)->create();

        Customer::factory(8)->create();
        Customer::factory(2)->withoutContact()->create();

        $customers = Customer::all();

        foreach ($customers as $customer) {
            Order::factory()
                ->for($customer)
                ->count(4)
                ->sequence(
                    ['status' => 'pending'],
                    ['status' => 'paid'],
                    ['status' => 'shipped'],
                    ['status' => 'canceled'],
                )
                ->withItems(rand(1, 4))
                ->create();
        }
    }
}