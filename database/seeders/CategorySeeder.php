<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Deshabilitar restricciones de foreign keys temporalmente
        Schema::disableForeignKeyConstraints();

        // Limpiar la tabla antes de insertar
        Category::query()->delete();

        // Resetear el auto-increment
        DB::statement('ALTER TABLE categories AUTO_INCREMENT = 1');

        // Crear las categorías usando el modelo Eloquent
        $categories = [
            [
                'name' => 'Entradas',
                'description' => 'Deliciosos aperitivos para comenzar',
                'image' => 'entradas.jpg',
                'status' => Category::STATUS_ACTIVE,
                'order_show' => 1,
            ],
            [
                'name' => 'Platos Principales',
                'description' => 'Nuestros platos más sustanciosos',
                'image' => 'principales.jpg',
                'status' => Category::STATUS_ACTIVE,
                'order_show' => 2,
            ],
            [
                'name' => 'Postres',
                'description' => 'Dulces tentaciones para terminar',
                'image' => 'postres.jpg',
                'status' => Category::STATUS_ACTIVE,
                'order_show' => 3,
            ],
            [
                'name' => 'Bebidas',
                'description' => 'Refrescos, jugos y bebidas calientes',
                'image' => 'bebidas.jpg',
                'status' => Category::STATUS_ACTIVE,
                'order_show' => 4,
            ],
            [
                'name' => 'Especialidades',
                'description' => 'Los platos únicos de la casa',
                'image' => 'especialidades.jpg',
                'status' => Category::STATUS_ACTIVE,
                'order_show' => 5,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Rehabilitar restricciones de foreign keys
        Schema::enableForeignKeyConstraints();
    }
}
