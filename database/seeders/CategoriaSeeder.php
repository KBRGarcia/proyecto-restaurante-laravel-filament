<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categorias = [
            [
                'id' => 1,
                'nombre' => 'Entradas',
                'descripcion' => 'Deliciosos aperitivos para comenzar',
                'imagen' => 'entradas.jpg',
                'orden_mostrar' => 1,
                'estado' => 'activo',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'nombre' => 'Platos Principales',
                'descripcion' => 'Nuestros platos más sustanciosos',
                'imagen' => 'principales.jpg',
                'orden_mostrar' => 2,
                'estado' => 'activo',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'nombre' => 'Postres',
                'descripcion' => 'Dulces tentaciones para terminar',
                'imagen' => 'postres.jpg',
                'orden_mostrar' => 3,
                'estado' => 'activo',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'nombre' => 'Bebidas',
                'descripcion' => 'Refrescos, jugos y bebidas calientes',
                'imagen' => 'bebidas.jpg',
                'orden_mostrar' => 4,
                'estado' => 'activo',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'nombre' => 'Especialidades',
                'descripcion' => 'Los platos únicos de la casa',
                'imagen' => 'especialidades.jpg',
                'orden_mostrar' => 5,
                'estado' => 'activo',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($categorias as $categoria) {
            DB::table('categorias')->insertOrIgnore($categoria);
        }
    }
}
