<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Port;
use File;

class SeaPortSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
<<<<<<< HEAD
        // Port::truncate();
=======
        //Port::truncate();
>>>>>>> 5774d2457b2de6c45ac3736fac0e005de89822ee
  
        $json = File::get("database/data/ports2.json");
        $ports = json_decode($json);

        foreach ($ports as $key => $port) {
            \DB::table('ports')->insert([
                "country_id" => intval($port->country_id),
                "name"       => $port->name,
                "province"	 => isset($port->province) ? $port->province : null ,
                "unlocs"     => $port->unlocs,
                "type"       => $port->type
            ]);
				
        }

        $json = File::get("database/data/airPorts.json");
        $ports = json_decode($json);

        foreach ($ports as $key => $port) {
            \DB::table('ports')->insert([
                "country_id" => intval($port->country_id),
                "name"       => $port->name,
                "province"	 => isset($port->province) ? $port->province : null ,
                "unlocs"     => $port->unlocs,
                "type"       => 'A'
            ]);
				
        }
    }
}
