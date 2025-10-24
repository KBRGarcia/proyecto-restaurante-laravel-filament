<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productos = [
            // Entradas
            [
                'nombre' => 'Alitas Buffalo',
                'descripcion' => 'Alitas de pollo con salsa picante buffalo',
                'precio' => 12.99,
                'categoria_id' => 1,
                'tiempo_preparacion' => 15,
                'es_especial' => false,
                'estado' => 'activo',
                'fecha_creacion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Nachos Supremos',
                'descripcion' => 'Nachos con queso, guacamole, crema y jalapeños',
                'precio' => 10.99,
                'categoria_id' => 1,
                'tiempo_preparacion' => 10,
                'es_especial' => false,
                'estado' => 'activo',
                'fecha_creacion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Calamares Fritos',
                'descripcion' => 'Anillos de calamar empanizados con salsa marinara',
                'precio' => 14.99,
                'categoria_id' => 1,
                'tiempo_preparacion' => 12,
                'es_especial' => false,
                'estado' => 'activo',
                'fecha_creacion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Platos Principales
            [
                'nombre' => 'Hamburguesa Clásica',
                'descripcion' => 'Carne de res, lechuga, tomate, cebolla y papas fritas',
                'precio' => 16.99,
                'categoria_id' => 2,
                'tiempo_preparacion' => 20,
                'es_especial' => false,
                'estado' => 'activo',
                'fecha_creacion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Filete de Salmón',
                'descripcion' => 'Salmón a la plancha con vegetales y arroz',
                'precio' => 22.99,
                'categoria_id' => 2,
                'tiempo_preparacion' => 25,
                'es_especial' => true,
                'estado' => 'activo',
                'fecha_creacion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Pasta Alfredo',
                'descripcion' => 'Fettuccine con salsa alfredo y pollo',
                'precio' => 18.99,
                'categoria_id' => 2,
                'tiempo_preparacion' => 18,
                'es_especial' => false,
                'estado' => 'activo',
                'fecha_creacion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Pizza Margherita',
                'descripcion' => 'Pizza tradicional con tomate, mozzarella y albahaca',
                'precio' => 15.99,
                'categoria_id' => 2,
                'tiempo_preparacion' => 20,
                'es_especial' => false,
                'estado' => 'activo',
                'fecha_creacion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Postres
            [
                'nombre' => 'Cheesecake',
                'descripcion' => 'Pastel de queso con frutos rojos',
                'precio' => 8.99,
                'categoria_id' => 3,
                'tiempo_preparacion' => 5,
                'es_especial' => false,
                'estado' => 'activo',
                'fecha_creacion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Brownie con Helado',
                'descripcion' => 'Brownie de chocolate caliente con helado de vainilla',
                'precio' => 7.99,
                'categoria_id' => 3,
                'tiempo_preparacion' => 8,
                'es_especial' => false,
                'estado' => 'activo',
                'fecha_creacion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Tiramisú',
                'descripcion' => 'Postre italiano con café y mascarpone',
                'precio' => 9.99,
                'categoria_id' => 3,
                'tiempo_preparacion' => 5,
                'es_especial' => true,
                'estado' => 'activo',
                'fecha_creacion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Bebidas
            [
                'nombre' => 'Coca Cola',
                'descripcion' => 'Refresco de cola 355ml',
                'precio' => 2.99,
                'categoria_id' => 4,
                'tiempo_preparacion' => 2,
                'es_especial' => false,
                'estado' => 'activo',
                'fecha_creacion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Jugo de Naranja Natural',
                'descripcion' => 'Jugo fresco de naranja 300ml',
                'precio' => 4.99,
                'categoria_id' => 4,
                'tiempo_preparacion' => 3,
                'es_especial' => false,
                'estado' => 'activo',
                'fecha_creacion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Café Americano',
                'descripcion' => 'Café negro recién preparado',
                'precio' => 3.99,
                'categoria_id' => 4,
                'tiempo_preparacion' => 5,
                'es_especial' => false,
                'estado' => 'activo',
                'fecha_creacion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Smoothie de Fresa',
                'descripcion' => 'Batido de fresa con yogurt',
                'precio' => 6.99,
                'categoria_id' => 4,
                'tiempo_preparacion' => 5,
                'es_especial' => false,
                'estado' => 'activo',
                'fecha_creacion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Especialidades
            [
                'nombre' => 'Paella Marinera',
                'descripcion' => 'Arroz con mariscos frescos (para 2 personas)',
                'precio' => 35.99,
                'categoria_id' => 5,
                'tiempo_preparacion' => 45,
                'es_especial' => true,
                'estado' => 'activo',
                'fecha_creacion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Ceviche Peruano',
                'descripcion' => 'Pescado fresco marinado en limón',
                'precio' => 19.99,
                'categoria_id' => 5,
                'tiempo_preparacion' => 15,
                'es_especial' => true,
                'estado' => 'activo',
                'fecha_creacion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($productos as $producto) {
            DB::table('productos')->insertOrIgnore($producto);
        }
    }
}
