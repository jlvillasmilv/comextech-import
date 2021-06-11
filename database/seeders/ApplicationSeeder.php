<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Application;

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
            'type'              => '1',
            'user_id'           => '2',
            'supplier_id'       => '1',
            'application_statuses_id'   => '1',
            'currency_id'       => 97,
            'description'       => 'Necesito importar un Equipo desde China con Valor del Equipo es Usd50.000,00',
            'fee1_date'           => date('Y-m-d'),
            'amount'            => '50000',
            'fee1'              => '20',
            'fee2'              => '80',
            'fee2_date'           => date('Y-m-d'),
            'estimated_date'    => date('Y-m-d'),           
        ]);


        \DB::table('application_details')->insert([
            [
                'application_id' => $application->id ,
                'service_id'  => 8,
                'amount'      =>  3990000,
                'currency_id' => 22,
                'amount2'     => 5700 ,
                'currency2_id' => 97,
                'estimated'   => date('Y-m-d'),
            ],
        ]);

        \DB::table('application_details')->insert([
            [
                'application_id' => $application->id ,
                'service_id'  => 9,
                'amount'      => 99750 ,
                'currency_id' => 22,
                'amount2'     => 143 ,
                'currency2_id' => 97,
                'estimated'   => date('Y-m-d'),
            ],
        ]);




    }
}
