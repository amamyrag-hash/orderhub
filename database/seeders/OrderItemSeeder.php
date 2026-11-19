<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all();

        Order::all()->each(function (Order $order) use ($products) {
          $picked = $products->random(min(rand(1, 4), $products->count()));

        foreach ($picked as $product) {
            OrderItem::factory()
            ->for($order)
            ->forProduct($product)
            ->create();
    }

    $total = $order->items()->get()->sum(
        fn (OrderItem $item) => $item->quantity * $item->unit_price
    );

    $order->update(['total_amount' => $total]);
});
    }
}
