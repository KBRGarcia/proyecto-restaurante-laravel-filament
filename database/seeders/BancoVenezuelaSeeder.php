<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BancoVenezuelaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bancos = [
            [
                'codigo' => '0108',
                'nombre' => 'BBVA Banco Provincial',
                'datos_sistema' => json_encode([
                    'cedula' => 'C.I- V-25478369',
                    'telefono' => '04142583614',
                    'tipo_cuenta' => 'Cuenta Corriente'
                ]),
                'activo' => true,
                'fecha_creacion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '0105',
                'nombre' => 'Banco Mercantil',
                'datos_sistema' => json_encode([
                    'cedula' => 'C.I- V-25478369',
                    'telefono' => '04142583614',
                    'tipo_cuenta' => 'Cuenta Corriente'
                ]),
                'activo' => true,
                'fecha_creacion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '0134',
                'nombre' => 'Banesco',
                'datos_sistema' => json_encode([
                    'cedula' => 'C.I- V-25478369',
                    'telefono' => '04142583614',
                    'tipo_cuenta' => 'Cuenta Corriente'
                ]),
                'activo' => true,
                'fecha_creacion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '0191',
                'nombre' => 'Banco Nacional de Crédito',
                'datos_sistema' => json_encode([
                    'cedula' => 'C.I- V-25478369',
                    'telefono' => '04142583614',
                    'tipo_cuenta' => 'Cuenta Corriente'
                ]),
                'activo' => true,
                'fecha_creacion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '0102',
                'nombre' => 'Banco de Venezuela',
                'datos_sistema' => json_encode([
                    'cedula' => 'C.I- V-25478369',
                    'telefono' => '04142583614',
                    'tipo_cuenta' => 'Cuenta Corriente'
                ]),
                'activo' => true,
                'fecha_creacion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => '0104',
                'nombre' => 'Venezolano de Crédito',
                'datos_sistema' => json_encode([
                    'cedula' => 'C.I- V-25478369',
                    'telefono' => '04142583614',
                    'tipo_cuenta' => 'Cuenta Corriente'
                ]),
                'activo' => true,
                'fecha_creacion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($bancos as $banco) {
            DB::table('bancos_venezuela')->insertOrIgnore($banco);
        }
    }
}
