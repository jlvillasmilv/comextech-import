<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategoryContainerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('category_containers')->insert([
            ["name" => "20'DV", "description" => "20'DV", "created_at" => now() ], 
            ["name" => "40'DV", "description" => "40'DV", "created_at" => now() ], 
            ["name" => "40'HC", "description" => "40'HC", "created_at" => now() ], 
            ["name" => "45'HC", "description" => "45'HC", "created_at" => now() ], 
        ]);
    }
}
