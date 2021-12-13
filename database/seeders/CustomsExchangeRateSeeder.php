<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CustomsExchangeRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('customs_exchange_rates')->insert([
            ['currency_code' => 'USD', 'amount' => 842.25, 'exchange' => date('Y-m-d')],
            ['currency_code' => 'CNY', 'amount' => 132.28, 'exchange' => date('Y-m-d')],
            ['currency_code' => 'EUR', 'amount' => 951.46, 'exchange' => date('Y-m-d')],
            ['currency_code' => 'MXN', 'amount' => 40.18, 'exchange'  => date('Y-m-d')],
            ['currency_code' => 'PEN', 'amount' => 0.19, 'exchange'   => date('Y-m-d')],
        ]);
    }
}
