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
             'icon'         => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10'
            ],
            [
             'name'         => 'AEREO',
             'description'  => 'TRANSPORTE AEREO',
             'icon'         => 'M12 19l9 2-9-18-9 18 9-2zm0 0v-8'
            ],
            [
             'name'        => 'CONTAINER',
             'description' => 'Transporte Courier envió de mensajería y paquetes.',
             'icon'        => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10'
            ],
            [
             'name' => 'CONSOLIDADO',
             'description' => 'El transporte de carga consolidada',
             'icon'        => 'M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z'
            ],
        ]);
    }
}
