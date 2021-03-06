<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Application,Service};

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $application = Application::create([
            'type'                    => 1,
            'user_id'                 => 2,
            'company_id'              => 1,
            'supplier_id'             => 1,
            'application_statuses_id' => 1,
            'currency_id'             => 2,
            'amount'                  => '50000',
            'condition'               => 'EXW',
            'type_transport'          => 'COURIER',
            'services_code'           => 'ICS03',
            'tco'                     => 7899,
            'currency_tco'            => 8,
            'tco_clp'                     => 6245597,
        ]);


        \DB::table('application_details')->insert([
            [
                'application_id' => $application->id,
                'service_id'  => 7,
                'category_service_id' => 3,
                'amount'      =>  3990000,
                'currency_id' => 1,
                'amount2'     => 5700,
                'currency2_id' => 8,
                'estimated'   => date('Y-m-d'),
            ],
            [
                'application_id' => $application->id,
                'category_service_id' => 3,
                'service_id'  => 8,
                'amount'      => 99750,
                'currency_id' => 1,
                'amount2'     => 143,
                'currency2_id' => 8,
                'estimated'   => date('Y-m-d'),
            ],
        ]);

        \DB::table('transports')->insert([
            [
                'application_id'        => $application->id,
                'fav_origin_address'    => true,
                'origin_address'        => 1,
                'fav_dest_address'      => true,
                'dest_address'          => 1,
                'estimated_date'        => date('Y-m-d'),
                'description'           => 'Carga',
                'mode_selected'         => 'COURIER',
            ]
        ]);

        \DB::table('loads')->insert([
            [  'application_id'  => $application->id,
                'cbm'            => 0.1728,
                'stackable'      => 0,
                'length_unit'    => 'CM',
                'length'         => 10,
                'width'          => 10,
                'height'         => 12,
                'mode_calculate' => 1,
                'type_container' => 1,
                'category_load_id' => 1,
                'weight'         => 12,
                'weight_units'   => 'KG',
            ]
        ]);

        $add_summary = Service::where('summary', true)
        ->select('id','name','category_service_id')
        ->orderby('name')
        ->get();

        foreach ($add_summary as $key => $item) {

            \DB::table('application_summaries')->insert([
                [   
                    "application_id"      => $application->id,
                    "category_service_id" => $item->category_service_id,
                    "service_id"          => $item->id, 
                    "currency_id"         => 1,
                    'amount2'             => 0,
                    'currency2_id'        => 8,
                    "fee_date"            => date('Y-m-d')
                ]
            ]);
        }

        
    }
}
