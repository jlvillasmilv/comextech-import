<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Warehouse;
use Illuminate\Support\Str;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $warehouse = Warehouse::create([
            'user_id'   => 1,
            'name'      => 'Local 8150933',
            'slug'     => Str::slug('Local 8150933', '-'),
            'postal_code' => '8150933',
            'address'  => 'Augusto Leguía Sur 79, Of. 1110, Las Condes, Región Metropolitana, Chile', 
            'phone_number' => '+56 2 2897 7070',
        ]);
    }
}
