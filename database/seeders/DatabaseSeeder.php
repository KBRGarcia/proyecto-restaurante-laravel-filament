<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('Iniciando proceso de seeding...');
        
        // Ejecutar seeders en orden específico para respetar las dependencias
        $this->call([
            RolePermissionSeeder::class, // Debe ejecutarse primero para crear roles y permisos
            UsuarioSeeder::class,
            CategoriaSeeder::class,
            ProductoSeeder::class,
            MetodoPagoSeeder::class,
            BancoVenezuelaSeeder::class,
            BranchSeeder::class,
            ProductoSucursalSeeder::class,
            OrdenSeeder::class,
            OrdenDetalleSeeder::class,
        ]);
        
        $this->command->info('Seeding completado exitosamente!');
        $this->command->info('Credenciales de acceso:');
        $this->command->info('Email: admin@restaurante.com');
        $this->command->info('Password: password');
    }
}
