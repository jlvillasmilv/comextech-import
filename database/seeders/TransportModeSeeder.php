<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TransportModeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('transport_modes')->insert([
            ['name'         => 'COURIER',
             'description'  => 'Transporte Courier envió de mensajería y paquetes.', 
             'icon'         => 'akar-icons:shipping-box-01'
            ],
            [
             'name'         => 'AEREO',
             'description'  => 'TRANSPORTE AEREO',
             'icon'         => 'bxs:plane-take-off'
            ],
            [
             'name'        => 'CONTAINER',
             'description' => 'Transporte Courier envió de mensajería y paquetes.',
             'icon'        => 'clarity:container-line'
            ],
            [
             'name' => 'CONSOLIDADO',
             'description' => 'El transporte de carga consolidada',
             'icon'        => 'bx:bar-chart-square'
            ],
        ]);
    }
}
