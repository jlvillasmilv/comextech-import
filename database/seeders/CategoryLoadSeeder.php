<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategoryLoadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('category_loads')->insert([
            ['name' => 'Caja / s', 'description' => 'Caja / s', 'created_at' => now() ],
            ['name' => 'Pallet / s', 'description' => 'Pallet / s', 'created_at' => now() ], 
            ['name' => 'Unidad/es', 'description' => 'Unidad/es', 'created_at' => now() ],
        ]);
    }
}
