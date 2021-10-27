<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FactoringSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // banks
        \DB::table('banks')->insert([
            ['name' => 'Banco de Chile', 'rut' => '97.004.000-5', 'observation' => '', 'status' => true, "created_at" => now()],
            ['name' => 'Banco Internacional', 'rut' => '97.011.000-3', 'observation' => '', 'status' => true, "created_at" => now()],
            ['name' => 'Scotiabank Chile', 'rut' => '97.018.000-1', 'observation' => '', 'status' => true, "created_at" => now()],
            ['name' => 'Banco de Crédito e Inversiones', 'rut' => '97.006.000-6', 'observation' => '', 'status' => true, "created_at" => now()],
            ['name' => 'Banco Bice', 'rut' => '97.080.000-K', 'observation' => '', 'status' => true, "created_at" => now()],
            ['name' => 'HSBC Bank (Chile)', 'rut' => '97.951.000-4', 'observation' => '', 'status' => true, "created_at" => now()],
            ['name' => 'Banco Santander', 'rut' => '97.036.000-K', 'observation' => '', 'status' => true, "created_at" => now()],
            ['name' => 'Banco Itaú Chile', 'rut' => '97.023.000-9', 'observation' => '', 'status' => true, "created_at" => now()],
            ['name' => 'Banco Security', 'rut' => '97.053.000-2', 'observation' => '', 'status' => true, "created_at" => now()],
            ['name' => 'Banco Falabella', 'rut' => '96.509.660-4', 'observation' => '', 'status' => true, "created_at" => now()],
            ['name' => 'Banco RIpley', 'rut' => '97.947.000-2', 'observation' => '', 'status' => true, "created_at" => now()],
            ['name' => 'Banco Consorcio', 'rut' => '99.500.410-0', 'observation' => '', 'status' => true, "created_at" => now()],
            ['name' => 'Bank of China Agencia en Chile', 'rut' => '59.238.930-4', 'observation' => '', 'status' => true, "created_at" => now()],
            ['name' => 'Banco del Estado de Chile', 'rut' => '97.030.000-7', 'observation' => '', 'status' => true, "created_at" => now()],
        ]);

        // disbursement_status
        \DB::table('factoring_disbursement_statuses')->insert([
            [
                'name' => 'PENDIENTE',
                'status_icon' => 'far fa-clock fa-2x',
                'status_color' => '#6c757d',
                'modify' => true,
                'rank' => 0,
                'created_at' => now(),
            ],
            [
                'name' => 'RECHAZADO',
                'status_icon' => 'fa fa-times fa-2x',
                'status_color' => 'red',
                'modify' => false,
                'rank' => 1,
                'created_at' => now(),
            ],
            [
                'name' => 'GIRO PENDIENTE',
                'status_icon' => 'far fa-clock fa-2x',
                'status_color' => '#6c757d',
                'modify' => true,
                'rank' => 1,
                'created_at' => now(),
            ],
            [
                'name' => 'DESEMBOLSADO',
                'status_icon' => 'fa fa-check-double fa-2x',
                'status_color' => '#1DC80D',
                'modify' => true,
                'rank' => 2,
                'created_at' => now(),
            ],
            [
                'name' => 'PAGADO',
                'status_icon' => 'fa fa-clipboard-check fa-2x',
                'status_color' => '#00BD2D',
                'modify' => false,
                'rank' => 3,
                'created_at' => now(),
            ],
            [
                'name' => 'EN MORA',
                'status_icon' => 'fa fa-exclamation-circle fa-2x',
                'status_color' => '#ECDD2C',
                'modify' => true,
                'rank' => 3,
                'created_at' => now(),
            ]
        ]);

        // 
        \DB::table('factoring_settlement_status')->insert([
            [
                'description' => 'Sin Información',
                'value' => 0,
                'icon'  =>'',
                'color' => '',
                'created_at' => now(),
            ],
            [
                'description' => 'Financiable',
                'value' => 1,
                'icon'  =>'',
                'color' => '',
                'created_at' => now(),
            ],
            [
                'description' => 'Muy Financiable',
                'value' => 2,
                'icon'  =>'',
                'color' => '',
                'created_at' => now(),
            ]
        ]);
    }
}
