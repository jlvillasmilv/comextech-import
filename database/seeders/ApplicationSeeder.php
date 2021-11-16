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
            'supplier_id'             => 1,
            'application_statuses_id' => 1,
            'currency_id'             => 1,
            'description'             => 'Necesito importar un Equipo desde China con Valor del Equipo es Usd50.000,00',
            'fee1_date'               => date('Y-m-d'),
            'amount'                  => '50000',
            'fee1'                    => '20',
            'fee2'                    => '80',
            'condition'               => 'EXW',
            'type_transport'          => 'COURIER',
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
                'fav_address_origin'    => true,
                'address_origin'        => 1,
                'fav_dest_address'      => true,
                'address_destination'   => 1,
                'estimated_date'        => date('Y-m-d'),
                'description'           => 'Carga',
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
                'mode_selected'  => 'COURIER',
                'type_container' => 1,
                'type_load'      => 1,
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
                    "currency_id"         => 8,
                    "fee_date"            => date('Y-m-d')
                ]
            ]);
        }

        
    }
}
