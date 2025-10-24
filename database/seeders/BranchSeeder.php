<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branches = [
            // Sucursal 1 - Principal
            [
                'nombre' => 'Sabor & Tradición - Centro',
                'direccion' => 'Av. Principal, Edificio Centro Plaza, Local 5',
                'ciudad' => 'Caracas',
                'estado' => 'Distrito Capital',
                'codigo_postal' => '1010',
                'telefono' => '0212-555-1234',
                'email' => 'centro@sabortradicion.com',
                'horario_apertura' => '09:00:00',
                'horario_cierre' => '23:00:00',
                'dias_operacion' => 'Lunes a Domingo',
                'latitud' => 10.50634800,
                'longitud' => -66.91462300,
                'es_principal' => true,
                'tiene_delivery' => true,
                'tiene_estacionamiento' => true,
                'capacidad_personas' => 120,
                'imagen' => 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=800',
                'descripcion' => 'Nuestra sucursal principal ubicada en el corazón de Caracas. Cuenta con amplios espacios, estacionamiento y servicio de delivery. Perfecta para reuniones familiares y eventos especiales.',
                'activo' => true,
                'fecha_apertura' => '2020-01-15',
                'gerente' => 'María Rodríguez',
                'fecha_creacion' => now(),
                'fecha_actualizacion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Sucursal 2 - Las Mercedes
            [
                'nombre' => 'Sabor & Tradición - Las Mercedes',
                'direccion' => 'Calle París con Av. Principal de Las Mercedes, C.C. Plaza Las Mercedes',
                'ciudad' => 'Caracas',
                'estado' => 'Distrito Capital',
                'codigo_postal' => '1060',
                'telefono' => '0212-555-2345',
                'email' => 'lasmercedes@sabortradicion.com',
                'horario_apertura' => '11:00:00',
                'horario_cierre' => '23:30:00',
                'dias_operacion' => 'Lunes a Domingo',
                'latitud' => 10.49504000,
                'longitud' => -66.85743000,
                'es_principal' => false,
                'tiene_delivery' => true,
                'tiene_estacionamiento' => true,
                'capacidad_personas' => 80,
                'imagen' => 'https://images.unsplash.com/photo-1552566626-52f8b828add9?w=800',
                'descripcion' => 'Ubicada en la exclusiva zona de Las Mercedes, esta sucursal ofrece un ambiente elegante y sofisticado. Ideal para cenas románticas y encuentros de negocios.',
                'activo' => true,
                'fecha_apertura' => '2021-03-20',
                'gerente' => 'Carlos Méndez',
                'fecha_creacion' => now(),
                'fecha_actualizacion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Sucursal 3 - Altamira
            [
                'nombre' => 'Sabor & Tradición - Altamira',
                'direccion' => 'Av. San Juan Bosco con 2da Transversal de Altamira',
                'ciudad' => 'Caracas',
                'estado' => 'Distrito Capital',
                'codigo_postal' => '1062',
                'telefono' => '0212-555-3456',
                'email' => 'altamira@sabortradicion.com',
                'horario_apertura' => '10:00:00',
                'horario_cierre' => '22:00:00',
                'dias_operacion' => 'Lunes a Sábado',
                'latitud' => 10.49677000,
                'longitud' => -66.85371000,
                'es_principal' => false,
                'tiene_delivery' => true,
                'tiene_estacionamiento' => false,
                'capacidad_personas' => 60,
                'imagen' => 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?w=800',
                'descripcion' => 'Nuestra sucursal boutique en Altamira combina tradición con modernidad. Ambiente acogedor perfecto para almuerzos de trabajo y reuniones casuales.',
                'activo' => true,
                'fecha_apertura' => '2021-07-10',
                'gerente' => 'Ana Fernández',
                'fecha_creacion' => now(),
                'fecha_actualizacion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Sucursal 4 - Valencia
            [
                'nombre' => 'Sabor & Tradición - Valencia',
                'direccion' => 'Av. Bolívar Norte, Centro Comercial Metrópolis, Nivel 2',
                'ciudad' => 'Valencia',
                'estado' => 'Carabobo',
                'codigo_postal' => '2001',
                'telefono' => '0241-555-4567',
                'email' => 'valencia@sabortradicion.com',
                'horario_apertura' => '10:00:00',
                'horario_cierre' => '22:00:00',
                'dias_operacion' => 'Lunes a Domingo',
                'latitud' => 10.16277000,
                'longitud' => -68.00779000,
                'es_principal' => false,
                'tiene_delivery' => true,
                'tiene_estacionamiento' => true,
                'capacidad_personas' => 100,
                'imagen' => 'https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=800',
                'descripcion' => 'Primera sucursal fuera de Caracas. Ubicada en el moderno Centro Comercial Metrópolis de Valencia, ofrece toda la tradición de nuestros sabores con amplias instalaciones.',
                'activo' => true,
                'fecha_apertura' => '2022-05-15',
                'gerente' => 'José Ramírez',
                'fecha_creacion' => now(),
                'fecha_actualizacion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Sucursal 5 - Maracaibo
            [
                'nombre' => 'Sabor & Tradición - Maracaibo',
                'direccion' => 'Av. 5 de Julio con Calle 72, Sector La Lago',
                'ciudad' => 'Maracaibo',
                'estado' => 'Zulia',
                'codigo_postal' => '4001',
                'telefono' => '0261-555-5678',
                'email' => 'maracaibo@sabortradicion.com',
                'horario_apertura' => '11:00:00',
                'horario_cierre' => '23:00:00',
                'dias_operacion' => 'Martes a Domingo',
                'latitud' => 10.66667000,
                'longitud' => -71.61667000,
                'es_principal' => false,
                'tiene_delivery' => true,
                'tiene_estacionamiento' => true,
                'capacidad_personas' => 90,
                'imagen' => 'https://images.unsplash.com/photo-1466978913421-dad2ebd01d17?w=800',
                'descripcion' => 'Nuestra más reciente apertura en la ciudad del sol amado. Diseño moderno con toques tradicionales, ofreciendo las mejores vistas del Lago de Maracaibo.',
                'activo' => true,
                'fecha_apertura' => '2023-02-28',
                'gerente' => 'Luis Pérez',
                'fecha_creacion' => now(),
                'fecha_actualizacion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($branches as $branch) {
            DB::table('branches')->insertOrIgnore($branch);
        }
    }
}
