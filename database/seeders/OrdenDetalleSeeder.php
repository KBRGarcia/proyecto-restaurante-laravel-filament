<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrdenDetalleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $detallesOrdenes = [
            // Orden 1
            [
                'orden_id' => 1,
                'producto_id' => 1, // Alitas Buffalo
                'cantidad' => 2,
                'precio_unitario' => 12.99,
                'subtotal' => 25.98,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'orden_id' => 1,
                'producto_id' => 5, // Filete de Salmón
                'cantidad' => 1,
                'precio_unitario' => 22.99,
                'subtotal' => 22.99,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Orden 2
            [
                'orden_id' => 2,
                'producto_id' => 4, // Hamburguesa Clásica
                'cantidad' => 1,
                'precio_unitario' => 16.99,
                'subtotal' => 16.99,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'orden_id' => 2,
                'producto_id' => 10, // Coca Cola
                'cantidad' => 1,
                'precio_unitario' => 2.99,
                'subtotal' => 2.99,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Orden 3
            [
                'orden_id' => 3,
                'producto_id' => 6, // Pasta Alfredo
                'cantidad' => 2,
                'precio_unitario' => 18.99,
                'subtotal' => 37.98,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'orden_id' => 3,
                'producto_id' => 8, // Cheesecake
                'cantidad' => 1,
                'precio_unitario' => 8.99,
                'subtotal' => 8.99,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Orden 4
            [
                'orden_id' => 4,
                'producto_id' => 7, // Pizza Margherita
                'cantidad' => 1,
                'precio_unitario' => 15.99,
                'subtotal' => 15.99,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'orden_id' => 4,
                'producto_id' => 11, // Jugo de Naranja Natural
                'cantidad' => 1,
                'precio_unitario' => 4.99,
                'subtotal' => 4.99,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Orden 5
            [
                'orden_id' => 5,
                'producto_id' => 2, // Nachos Supremos
                'cantidad' => 3,
                'precio_unitario' => 10.99,
                'subtotal' => 32.97,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'orden_id' => 5,
                'producto_id' => 12, // Café Americano
                'cantidad' => 2,
                'precio_unitario' => 3.99,
                'subtotal' => 7.98,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($detallesOrdenes as $detalle) {
            DB::table('orden_detalles')->insertOrIgnore($detalle);
        }
    }
}
