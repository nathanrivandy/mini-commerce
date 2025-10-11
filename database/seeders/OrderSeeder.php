<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('role', 'user')->get();
        $products = Product::all();

        if ($users->isEmpty() || $products->isEmpty()) {
            $this->command->warn('No users or products found. Please run UserSeeder and ProductSeeder first.');
            return;
        }

        $statuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
        
        // Create 50 sample orders
        for ($i = 1; $i <= 50; $i++) {
            $user = $users->random();
            $status = $statuses[array_rand($statuses)];
            
            $order = Order::create([
                'user_id' => $user->id,
                'status' => $status,
                'address_text' => 'Jl. Contoh No. ' . rand(1, 100) . ', Jakarta',
                'phone' => '08' . rand(10000000, 99999999),
                'notes' => $i % 3 === 0 ? 'Tolong kirim cepat ya' : null,
                'total' => 0, // Will be calculated below
                'created_at' => now()->subDays(rand(1, 90)),
            ]);

            $total = 0;
            $itemCount = rand(1, 5); // 1-5 items per order

            for ($j = 0; $j < $itemCount; $j++) {
                $product = $products->random();
                $qty = rand(1, 3);
                $price = $product->price;
                $subtotal = $price * $qty;
                $total += $subtotal;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'price' => $price,
                    'qty' => $qty,
                    'subtotal' => $subtotal,
                ]);
            }

            $order->update(['total' => $total]);
        }

        $this->command->info('Created 50 sample orders with items.');
    }
}