<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EcommerceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('ecommerces')->insert([
            ['user_id' => 1, 'name' => 'Aliexpress'],
            ['user_id' => 1, 'name' => 'Alibaba'],
            ['user_id' => 1, 'name' => 'Jumore'],
            ['user_id' => 1, 'name' => 'MercadoLibre'],
        ]);
    }
}
