<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Order;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
