<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use File;

class RateTransportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/rate_fcl.json");
        $fcl = json_decode($json);

        foreach ($fcl as $key => $fc) {
            \DB::table('rate_fcl')->insert([
                ['user_id' => 1,
                'from'      => $fc->from,
                'to'        => $fc->to,
                'via'       => $fc->via, 
                't_time'    => $fc->t_time,
                'currency'  => $fc->currency,
                'valid_from' => date('Y-m-d'),
                'valid_to'   => date('Y-m-d'),
                'c20'       => $fc->c20,
                'c40'       => $fc->c40,
                'c40HC'     => $fc->c40HC,
                'c40NOR'    => $fc->c40NOR,
                'oth_exp'        => $fc->gl,
             ], 
            ]);
				
        }

        $json = File::get("database/data/rate_lcl.json");
        $lcl = json_decode($json);

        foreach ($lcl as $key => $fc) {
            \DB::table('rate_lcl')->insert([
                [
                'user_id'   => 1,
                'agent_name' => $fc->agent_name,
                'shipping_line'  => $fc->shipping_line,
                'coloader'  => $fc->coloader,
                'contract'  => $fc->contract,
                'from'      => $fc->from,
                'to'        => $fc->to,
                'via'       => $fc->via, 
                't_time'    => $fc->t_time,
                'currency'  => $fc->currency,
                'valid_from' => date('Y-m-d'),
                'valid_to'   => date('Y-m-d'),
                'MIN_0_5'    => $fc->MIN_0_5,
                'w0_5_TON_M3' => $fc->w0_5_TON_M3,
                'MIN_5_10'  => $fc->MIN_5_10,
                'w5_10_TON_M3' => $fc->w5_10_TON_M3,
                'MIN_10_5' => $fc->MIN_10_5,
                'w10_15_TON_M3' => $fc->w10_15_TON_M3,
                'oth_exp'     => $fc->gl,
             ], 
            ]);
				
        }

        // local transport
        \DB::table('rate_local_transports')->insert([
        [
            'user_id'   => 1,
            'weight'    => 0,
            'weight_limit' => 200,
            'weight_units' => 'KG',
            'amount'    => 20000,
            'from'      => 'SCL',
            'to'        => 'Santiago',
            'type'      => 'A',
         ], 
         [
            'user_id'   => 1,
            'weight'    => 201,
            'weight_limit' => 500,
            'weight_units' => 'KG',
            'amount'    => 28500,
            'from'      => 'SCL',
            'to'        => 'Santiago',
            'type'      => 'A',
         ], 
         [
            'user_id'   => 1,
            'weight'    => 501,
            'weight_limit' => 1000,
            'weight_units' => 'KG',
            'amount'    => 35000,
            'from'      => 'SCL',
            'to'        => 'Santiago',
            'type'      => 'A',
         ],
         [
            'user_id'   => 1,
            'weight'    => 1001,
            'weight_limit' => 2000,
            'weight_units' => 'KG',
            'amount'    => 50000,
            'from'      => 'SCL',
            'to'        => 'Santiago',
            'type'      => 'A',
         ], 
         [
            'user_id'   => 1,
            'weight'    => 2001,
            'weight_limit' => 3000,
            'weight_units' => 'KG',
            'amount'    => 60000,
            'from'      => 'SCL',
            'to'        => 'Santiago',
            'type'      => 'A',
         ], 
         [
            'user_id'   => 1,
            'weight'    => 3001,
            'weight_limit' => 5000,
            'weight_units' => 'KG',
            'amount'    => 70000,
            'from'      => 'SCL',
            'to'        => 'Santiago',
            'type'      => 'A',
         ], 

         [
            'user_id'   => 1,
            'weight'    => 5001,
            'weight_limit' => 10000,
            'weight_units' => 'KG',
            'amount'    => 130000,
            'from'      => 'SCL',
            'to'        => 'Santiago',
            'type'      => 'A',
         ], 

         [
            'user_id'   => 1,
            'weight'    => 10001,
            'weight_limit' => 25000,
            'weight_units' => 'KG',
            'amount'    => 130000,
            'from'      => 'SCL',
            'to'        => 'Santiago',
            'type'      => 'A',
         ], 

         [
            'user_id'   => 1,
            'weight'    => 0,
            'weight_limit' => 200,
            'weight_units' => 'KG',
            'amount'    => 60000,
            'from'      => 'SCL',
            'to'        => 'Santiago',
            'type'      => 'P',
         ], 
         [
            'user_id'   => 1,
            'weight'    => 201,
            'weight_limit' => 500,
            'weight_units' => 'KG',
            'amount'    => 80000,
            'from'      => 'SCL',
            'to'        => 'Santiago',
            'type'      => 'P',
         ], 
         [
            'user_id'   => 1,
            'weight'    => 501,
            'weight_limit' => 1000,
            'weight_units' => 'KG',
            'amount'    => 105000,
            'from'      => 'SCL',
            'to'        => 'Santiago',
            'type'      => 'P',
         ],
         [
            'user_id'   => 1,
            'weight'    => 1001,
            'weight_limit' => 2000,
            'weight_units' => 'KG',
            'amount'    => 120000,
            'from'      => 'SCL',
            'to'        => 'Santiago',
            'type'      => 'P',
         ], 
         [
            'user_id'   => 1,
            'weight'    => 2001,
            'weight_limit' => 3000,
            'weight_units' => 'KG',
            'amount'    => 150000,
            'from'      => 'SCL',
            'to'        => 'Santiago',
            'type'      => 'P',
         ], 
         [
            'user_id'   => 1,
            'weight'    => 3001,
            'weight_limit' => 5000,
            'weight_units' => 'KG',
            'amount'    => 170000,
            'from'      => 'SCL',
            'to'        => 'Santiago',
            'type'      => 'P',
         ], 

         [
            'user_id'   => 1,
            'weight'    => 5001,
            'weight_limit' => 10000,
            'weight_units' => 'KG',
            'amount'    => 220000,
            'from'      => 'SCL',
            'to'        => 'Santiago',
            'type'      => 'P',
         ], 

         [
            'user_id'   => 1,
            'weight'    => 10001,
            'weight_limit' => 25000,
            'weight_units' => 'KG',
            'amount'    => 240000,
            'from'      => 'SCL',
            'to'        => 'Santiago',
            'type'      => 'P',
         ],
          
        ]);
    }
}
