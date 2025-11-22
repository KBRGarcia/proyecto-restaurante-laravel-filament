<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VenezuelaBank;
use Carbon\Carbon;

class VenezuelaBankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $banks = [
            [
                'code' => '0108',
                'name' => 'BBVA Banco Provincial',
                'active' => true,
                'creation_date' => Carbon::now(),
            ],
            [
                'code' => '0105',
                'name' => 'Banco Mercantil',
                'active' => true,
                'creation_date' => Carbon::now(),
            ],
            [
                'code' => '0134',
                'name' => 'Banesco',
                'active' => true,
                'creation_date' => Carbon::now(),
            ],
            [
                'code' => '0191',
                'name' => 'Banco Nacional de Crédito',
                'active' => true,
                'creation_date' => Carbon::now(),
            ],
            [
                'code' => '0102',
                'name' => 'Banco de Venezuela',
                'active' => true,
                'creation_date' => Carbon::now(),
            ],
            [
                'code' => '0104',
                'name' => 'Venezolano de Crédito',
                'active' => true,
                'creation_date' => Carbon::now(),
            ],
        ];

        foreach ($banks as $bank) {
            VenezuelaBank::updateOrCreate(
                ['code' => $bank['code']], // Buscar por código
                $bank // Actualizar o crear con estos datos
            );
        }
    }
}
