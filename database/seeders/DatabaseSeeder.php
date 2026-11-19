<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
        public function run()
        {
            $this->call([
                UserSeeder::class,
                CategorySeeder::class,
                CustomerSeeder::class,
                ProductSeeder::class,
                OrderSeeder::class,
                OrderItemSeeder::class,
            ]);
        }
}


