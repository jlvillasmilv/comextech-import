<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\SupplierAddress::factory(8)->create();
    }
}
