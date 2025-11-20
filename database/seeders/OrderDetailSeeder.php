<?php

namespace Database\Seeders;

use App\Models\OrderDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orderDetails = [
            // Orden 1
            [
                'order_id' => 1,
                'product_id' => 1,
                'quantity' => 2,
                'unit_price' => 12.99,
                'subtotal' => 25.98,
            ],
            [
                'order_id' => 1,
                'product_id' => 5,
                'quantity' => 1,
                'unit_price' => 22.99,
                'subtotal' => 22.99,
            ],
            
            // Orden 2
            [
                'order_id' => 2,
                'product_id' => 4,
                'quantity' => 1,
                'unit_price' => 16.99,
                'subtotal' => 16.99,
            ],
            [
                'order_id' => 2,
                'product_id' => 10,
                'quantity' => 1,
                'unit_price' => 2.99,
                'subtotal' => 2.99,
            ],
            
            // Orden 3
            [
                'order_id' => 3,
                'product_id' => 6,
                'quantity' => 2,
                'unit_price' => 18.99,
                'subtotal' => 37.98,
            ],
            [
                'order_id' => 3,
                'product_id' => 8,
                'quantity' => 1,
                'unit_price' => 8.99,
                'subtotal' => 8.99,
            ],
            
            // Orden 4
            [
                'order_id' => 4,
                'product_id' => 7,
                'quantity' => 1,
                'unit_price' => 15.99,
                'subtotal' => 15.99,
            ],
            [
                'order_id' => 4,
                'product_id' => 11,
                'quantity' => 1,
                'unit_price' => 4.99,
                'subtotal' => 4.99,
            ],
            
            // Orden 5
            [
                'order_id' => 5,
                'product_id' => 2,
                'quantity' => 3,
                'unit_price' => 10.99,
                'subtotal' => 32.97,
            ],
            [
                'order_id' => 5,
                'product_id' => 12,
                'quantity' => 2,
                'unit_price' => 3.99,
                'subtotal' => 7.98,
            ],
        ];

        foreach ($orderDetails as $orderDetail) {
            OrderDetail::create($orderDetail);
        }
    }
}
