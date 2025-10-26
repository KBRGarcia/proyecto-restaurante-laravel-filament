<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Usuario administrador por defecto
        $admin = Usuario::create([
            'nombre' => 'Admin',
            'apellido' => 'Principal',
            'correo' => 'admin@restaurante.com',
            'password' => Hash::make('password'),
            'rol' => 'admin',
            'estado' => 'activo',
            'fecha_registro' => now(),
        ]);
        $admin->assignRole('admin');

        // Usuario super administrador
        $superAdmin = Usuario::create([
            'nombre' => 'Super',
            'apellido' => 'Admin',
            'correo' => 'superadmin@restaurante.com',
            'password' => Hash::make('password'),
            'rol' => 'admin',
            'estado' => 'activo',
            'fecha_registro' => now(),
        ]);
        $superAdmin->assignRole('super-admin');

        // Usuario gerente
        $gerente = Usuario::create([
            'nombre' => 'Gerente',
            'apellido' => 'Principal',
            'correo' => 'gerente@restaurante.com',
            'password' => Hash::make('password'),
            'telefono' => '+1 555-0001',
            'direccion' => 'Oficina Principal',
            'rol' => 'admin',
            'estado' => 'activo',
            'fecha_registro' => now(),
        ]);
        $gerente->assignRole('gerente');

        // Usuario empleado
        $empleado = Usuario::create([
            'nombre' => 'Empleado',
            'apellido' => 'Principal',
            'correo' => 'empleado@restaurante.com',
            'password' => Hash::make('password'),
            'telefono' => '+1 555-0002',
            'direccion' => 'Sucursal Principal',
            'rol' => 'empleado',
            'estado' => 'activo',
            'fecha_registro' => now(),
        ]);
        $empleado->assignRole('empleado');

        // Usuarios de prueba (clientes)
        $usuarios = [
            [
                'nombre' => 'Juan',
                'apellido' => 'Pérez',
                'correo' => 'juan@example.com',
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
                'telefono' => '+1 555-0105',
                'direccion' => 'Avenida 5 #654',
                'rol' => 'cliente',
                'estado' => 'activo',
                'fecha_registro' => '2024-05-12 11:00:00',
            ],
        ];

        foreach ($usuarios as $usuarioData) {
            $usuario = Usuario::create(array_merge($usuarioData, [
                'password' => Hash::make('password'),
            ]));
            $usuario->assignRole('cliente');
        }
    }
}
