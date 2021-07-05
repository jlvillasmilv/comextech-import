<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SupplCondSale;

class SupplCondSaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $sup = SupplCondSale::create([
            'user_id'   => 1,
            'name'      => 'FOB',
        ]);

        $sup->services()->sync([1,3]);

        $sup = SupplCondSale::create([
            'user_id'   => 1,
            'name'      => 'DDP/DAP',
        ]);

        $sup->services()->sync([4,5]);

        $sup = SupplCondSale::create([
            'user_id'   => 1,
            'name'      => 'EXW',
        ]);

        $sup->services()->sync([4,5]);

        $sup = SupplCondSale::create([
            'user_id'   => 1,
            'name'      => 'CIF',
        ]);

        $sup->services()->sync([4,5]);

    }
}
