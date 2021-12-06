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
                'gl'        => $fc->gl,
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
                'gl'     => $fc->gl,
             ], 
            ]);
				
        }
    }
}
