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
        Port::truncate();
  
        $json = File::get("database/data/ports.json");
        $ports = json_decode($json);

        foreach ($ports as $key => $port) {
            Port::create([
                "id"         => intval($port->id),
                "country_id" => intval($port->country_id),
                "name"       => $port->name,
                "province"	 => isset($port->province) ? $port->province : null ,
                "unlocs"     => $port->unlocs,
            ]);
				
        }
    }
}
