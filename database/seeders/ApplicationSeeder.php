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
            'type'      => '1',
            'user_id'   => '2',
            'application_statuses_id'   => '1',
            'description'   => 'Necesito importar un Equipo desde China con Valor del Equipo es Usd50.000,00',
            'estimated_date_delivery'   => date('Y-m-d'),           
        ]);



        // $application->details()->create([
        //     'country_id' => '44',
        //     'tax_id'  => '76722268-8',
        //     'name'    => 'Comextech',
        //     'address' => 'Augusto Leguía Sur 79, Oficina 1110. Las Condes, Chile'
        //     'email'   => 'info@Comex.Tech',
        //     'phone'   => '+56228977070',
        //     'contact_name'   => 'Andres Fabregat',
        //     'status'  => 1
        // ]);




    }
}
