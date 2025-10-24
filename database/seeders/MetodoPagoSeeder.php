<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MetodoPagoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $metodosPago = [
            // Métodos de pago internacionales
            [
                'codigo' => 'tarjeta',
                'nombre' => 'Tarjeta de Crédito/Débito',
                'tipo_moneda' => 'internacional',
                'configuracion' => json_encode([
                    'tipos' => ['visa', 'mastercard'],
                    'requiere_cvv' => true
                ]),
                'activo' => true,
                'fecha_creacion' => now(),
                'fecha_actualizacion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => 'paypal',
                'nombre' => 'PayPal',
                'tipo_moneda' => 'internacional',
                'configuracion' => json_encode([
                    'redireccion' => true,
                    'requiere_password' => true
                ]),
                'activo' => true,
                'fecha_creacion' => now(),
                'fecha_actualizacion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => 'zinli',
                'nombre' => 'Zinli',
                'tipo_moneda' => 'internacional',
                'configuracion' => json_encode([
                    'requiere_pin' => true,
                    'longitud_pin' => 4
                ]),
                'activo' => true,
                'fecha_creacion' => now(),
                'fecha_actualizacion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => 'zelle',
                'nombre' => 'Zelle',
                'tipo_moneda' => 'internacional',
                'configuracion' => json_encode([
                    'requiere_nombre_completo' => true
                ]),
                'activo' => true,
                'fecha_creacion' => now(),
                'fecha_actualizacion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Métodos de pago nacionales
            [
                'codigo' => 'pago_movil',
                'nombre' => 'Pago Móvil',
                'tipo_moneda' => 'nacional',
                'configuracion' => json_encode([
                    'requiere_cedula' => true,
                    'requiere_referencia' => true,
                    'bancos_disponibles' => ['provincial', 'mercantil', 'banesco', 'bnc', 'bdv', 'venezolano']
                ]),
                'activo' => true,
                'fecha_creacion' => now(),
                'fecha_actualizacion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => 'transferencia',
                'nombre' => 'Transferencia Bancaria',
                'tipo_moneda' => 'nacional',
                'configuracion' => json_encode([
                    'requiere_cedula' => true,
                    'requiere_referencia' => true,
                    'bancos_disponibles' => ['provincial', 'mercantil', 'banesco', 'bnc', 'bdv', 'venezolano']
                ]),
                'activo' => true,
                'fecha_creacion' => now(),
                'fecha_actualizacion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => 'fisico',
                'nombre' => 'Pago Físico',
                'tipo_moneda' => 'nacional',
                'configuracion' => json_encode([
                    'solo_recoger' => true,
                    'limite_horas' => 3,
                    'requiere_confirmacion_admin' => true
                ]),
                'activo' => true,
                'fecha_creacion' => now(),
                'fecha_actualizacion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($metodosPago as $metodo) {
            DB::table('metodos_pago')->insertOrIgnore($metodo);
        }
    }
}
