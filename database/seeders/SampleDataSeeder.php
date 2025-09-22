<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Keranjang;
use Illuminate\Database\Seeder;

class SampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * This seeder creates some sample cart and order data for testing
     */
    public function run(): void
    {
        // Get some users and products
        $users = User::where('role', 'user')->get();
        $products = Product::where('stock', '>', 0)->take(10)->get();

        if ($users->count() > 0 && $products->count() > 0) {
            // Create sample keranjang for first user
            $user = $users->first();
            $keranjang = Keranjang::create([
                'user_id' => $user->id,
            ]);

            // Add some items to keranjang
            foreach ($products->take(3) as $product) {
                $keranjang->items()->create([
                    'product_id' => $product->id,
                    'quantity' => rand(1, 3),
                ]);
            }

            // Create some sample orders
            foreach ($users->take(2) as $user) {
                $order = Order::create([
                    'user_id' => $user->id,
                    'total_amount' => 0,
                    'status' => collect(['pending', 'processing', 'completed'])->random(),
                    'shipping_address' => 'Jl. Contoh No. 123, Jakarta',
                    'phone' => '08123456789',
                    'notes' => 'Tolong kirim dengan hati-hati',
                ]);

                $totalAmount = 0;
                
                // Add order items
                foreach ($products->random(rand(2, 4)) as $product) {
                    $quantity = rand(1, 2);
                    $price = $product->price;
                    
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'price' => $price,
                    ]);
                    
                    $totalAmount += ($price * $quantity);
                }
                
                // Update order total
                $order->update(['total_amount' => $totalAmount]);
            }

            $this->command->info('Sample cart and order data created successfully!');
        } else {
            $this->command->warn('Not enough users or products to create sample data.');
        }
    }
}