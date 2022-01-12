<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TransCompaniesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('trans_companies')->insert([
            ['user_id'   => 1,
             'name' => 'CHILEEXPRESS',
             'description' => 'Servicios de envío',
             'url' => 'https://www.chilexpress.cl/',
             'status' => false,
             'created_at' => now()
             ],
            ['user_id'   => 1,
             'name' => 'FEDEX',
             'description' => 'Servicios de envío',
             'url' => 'https://www.fedex.com/es-pr/home.html',
             'status' => true,
             'created_at' => now()
             ],
             ['user_id'   => 1,
             'name' => 'DHL',
             'description' => 'Servicios de envío',
             'url' => 'https://www.dhl.com/cl-es/home.html',
             'status' => true,
             'created_at' => now()
             ],
             ['user_id'   => 1,
             'name' => 'UPS',
             'description' => 'Empresa de transporte de paquetes',
             'url' => 'https://www.ups.com/',
             'status' => false,
             'created_at' => now()
             ],


        ]);
    }
}
