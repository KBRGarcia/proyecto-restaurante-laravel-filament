<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductoSucursalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener el ID de la sucursal principal
        $sucursalPrincipal = DB::table('branches')
            ->where('es_principal', true)
            ->first();

        if (!$sucursalPrincipal) {
            $this->command->warn('No se encontró la sucursal principal. Saltando asignación de productos.');
            return;
        }

        // Obtener todos los productos activos
        $productos = DB::table('productos')
            ->where('estado', 'activo')
            ->get();

        // Insertar todos los productos en la sucursal principal
        foreach ($productos as $producto) {
            // Verificar si ya existe la relación
            $existe = DB::table('producto_sucursal')
                ->where('producto_id', $producto->id)
                ->where('sucursal_id', $sucursalPrincipal->id)
                ->exists();

            if (!$existe) {
                DB::table('producto_sucursal')->insert([
                    'producto_id' => $producto->id,
                    'sucursal_id' => $sucursalPrincipal->id,
                    'disponible' => true,
                    'precio_especial' => null,
                    'fecha_asignacion' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        $this->command->info('Productos asignados a la sucursal principal exitosamente.');
    }
}
