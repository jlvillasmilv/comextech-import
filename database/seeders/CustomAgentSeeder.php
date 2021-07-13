<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CustomAgentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('custom_agents')->insert([
            ['rut'            => '89324543-k',
             'name'           => 'Aduana 1',
             'contact_person' => 'Mateo Santiago González',
             'rate'           => 1234,
             'bank'           => 'Banco Del Estado De Chile',
             'account_number' => 'ES19 0001 0000 1000 0000 0000',
             'user_id'        => 1,
             'created_at'     => now() ], 

             ['rut'           => '89324543-k',
             'name'           => 'Aduana Prueba cliente 2',
             'contact_person' => 'Mateo Santiago González',
             'rate'           => 1234,
             'bank'           => 'Banco Del Estado De Chile',
             'account_number' => 'ES19 0001 0000 1000 0000 0000',
             'user_id'        => 2,
             'created_at'     => now() ], 
        ]);
    }
}
