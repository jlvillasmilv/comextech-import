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
            ['name' => 'Caja', 'description' => 'Caja', 'created_at' => now() ],
            ['name' => 'Pallet', 'description' => 'Pallet', 'created_at' => now() ], 
            ['name' => 'Unidad', 'description' => 'Unidad', 'created_at' => now() ],
        ]);
    }
}
