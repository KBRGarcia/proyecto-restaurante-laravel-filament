<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Usuario administrador por defecto
        DB::table('usuarios')->insertOrIgnore([
            'id' => 1,
            'nombre' => 'Admin',
            'apellido' => 'Principal',
            'correo' => 'admin@restaurante.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'rol' => 'admin',
            'estado' => 'activo',
            'fecha_registro' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Usuarios de prueba (clientes)
        $usuarios = [
            [
                'nombre' => 'Juan',
                'apellido' => 'Pérez',
                'correo' => 'juan@example.com',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'telefono' => '+1 555-0101',
                'direccion' => 'Calle 1 #123',
                'rol' => 'cliente',
                'estado' => 'activo',
                'fecha_registro' => '2024-01-15 10:30:00',
            ],
            [
                'nombre' => 'María',
                'apellido' => 'González',
                'correo' => 'maria@example.com',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'telefono' => '+1 555-0102',
                'direccion' => 'Avenida 2 #456',
                'rol' => 'cliente',
                'estado' => 'activo',
                'fecha_registro' => '2024-02-20 14:15:00',
            ],
            [
                'nombre' => 'Carlos',
                'apellido' => 'Rodríguez',
                'correo' => 'carlos@example.com',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'telefono' => '+1 555-0103',
                'direccion' => 'Boulevard 3 #789',
                'rol' => 'cliente',
                'estado' => 'inactivo',
                'fecha_registro' => '2024-03-10 09:45:00',
            ],
            [
                'nombre' => 'Ana',
                'apellido' => 'Martínez',
                'correo' => 'ana@example.com',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'telefono' => '+1 555-0104',
                'direccion' => 'Calle 4 #321',
                'rol' => 'cliente',
                'estado' => 'activo',
                'fecha_registro' => '2024-04-05 16:20:00',
            ],
            [
                'nombre' => 'Luis',
                'apellido' => 'López',
                'correo' => 'luis@example.com',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'telefono' => '+1 555-0105',
                'direccion' => 'Avenida 5 #654',
                'rol' => 'cliente',
                'estado' => 'activo',
                'fecha_registro' => '2024-05-12 11:00:00',
            ],
            [
                'nombre' => 'Sofia',
                'apellido' => 'Hernández',
                'correo' => 'sofia@example.com',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'telefono' => '+1 555-0106',
                'direccion' => 'Boulevard 6 #987',
                'rol' => 'cliente',
                'estado' => 'activo',
                'fecha_registro' => '2024-06-18 13:30:00',
            ],
            [
                'nombre' => 'Diego',
                'apellido' => 'García',
                'correo' => 'diego@example.com',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'telefono' => '+1 555-0107',
                'direccion' => 'Calle 7 #159',
                'rol' => 'cliente',
                'estado' => 'activo',
                'fecha_registro' => '2024-07-22 15:45:00',
            ],
            [
                'nombre' => 'Elena',
                'apellido' => 'Díaz',
                'correo' => 'elena@example.com',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'telefono' => '+1 555-0108',
                'direccion' => 'Avenida 8 #753',
                'rol' => 'cliente',
                'estado' => 'activo',
                'fecha_registro' => '2024-08-30 10:15:00',
            ],
            [
                'nombre' => 'Miguel',
                'apellido' => 'Ramírez',
                'correo' => 'miguel@example.com',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'telefono' => '+1 555-0109',
                'direccion' => 'Boulevard 9 #951',
                'rol' => 'cliente',
                'estado' => 'activo',
                'fecha_registro' => '2024-09-14 12:00:00',
            ],
            [
                'nombre' => 'Laura',
                'apellido' => 'Torres',
                'correo' => 'laura@example.com',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'telefono' => '+1 555-0110',
                'direccion' => 'Calle 10 #852',
                'rol' => 'cliente',
                'estado' => 'activo',
                'fecha_registro' => '2024-10-01 14:30:00',
            ],
        ];

        foreach ($usuarios as $usuario) {
            DB::table('usuarios')->insertOrIgnore(array_merge($usuario, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
