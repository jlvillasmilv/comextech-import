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
            ['name' => 'AEREO', 'description' => 'TRANSPORTE AEREO' ],
            ['name' => 'COURIER', 'description' => 'Transporte Courier envió de mensajería y paquetes.' ],
            ['name' => 'CONSOLIDADO', 'description' => 'El transporte de carga consolidada' ],
        ]);
    }
}
