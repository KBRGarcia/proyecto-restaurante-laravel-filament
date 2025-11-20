<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $paymentMethods = [
            // Métodos de pago internacionales
            [
                'code' => 'tarjeta',
                'name' => 'Tarjeta de Crédito/Débito',
                'currency_type' => 'internacional',
                'active' => true,
                'configuration' => [
                    'tipos' => ['visa', 'mastercard'],
                    'requiere_cvv' => true,
                ],
            ],
            [
                'code' => 'paypal',
                'name' => 'PayPal',
                'currency_type' => 'internacional',
                'active' => true,
                'configuration' => [
                    'redireccion' => true,
                    'requiere_password' => true,
                ],
            ],
            [
                'code' => 'zinli',
                'name' => 'Zinli',
                'currency_type' => 'internacional',
                'active' => true,
                'configuration' => [
                    'requiere_pin' => true,
                    'longitud_pin' => 4,
                ],
            ],
            [
                'code' => 'zelle',
                'name' => 'Zelle',
                'currency_type' => 'internacional',
                'active' => true,
                'configuration' => [
                    'requiere_nombre_completo' => true,
                ],
            ],

            // Métodos de pago nacionales
            [
                'code' => 'pago_movil',
                'name' => 'Pago Móvil',
                'currency_type' => 'nacional',
                'active' => true,
                'configuration' => [
                    'requiere_cedula' => true,
                    'requiere_referencia' => true,
                    'bancos_disponibles' => ['provincial', 'mercantil', 'banesco', 'bnc', 'bdv', 'venezolano'],
                ],
            ],
            [
                'code' => 'transferencia',
                'name' => 'Transferencia Bancaria',
                'currency_type' => 'nacional',
                'active' => true,
                'configuration' => [
                    'requiere_cedula' => true,
                    'requiere_referencia' => true,
                    'bancos_disponibles' => ['provincial', 'mercantil', 'banesco', 'bnc', 'bdv', 'venezolano'],
                ],
            ],
            [
                'code' => 'fisico',
                'name' => 'Pago Físico',
                'currency_type' => 'nacional',
                'active' => true,
                'configuration' => [
                    'solo_recoger' => true,
                    'limite_horas' => 3,
                    'requiere_confirmacion_admin' => true,
                ],
            ],
        ];

        foreach ($paymentMethods as $paymentMethod) {
            PaymentMethod::updateOrCreate(
                ['code' => $paymentMethod['code']],
                $paymentMethod
            );
        }
    }
}
