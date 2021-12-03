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
            ["name" => "20",  "description"  => "20'DV",  "created_at" => now() ], 
            ["name" => "40",  "description"  => "40'DV",  "created_at" => now() ], 
            ["name" => "40HC", "description"  => "40'HC", "created_at" => now() ],
            ["name" => "40NOR","description"  => "40'NOR","created_at" => now() ], 
            ["name" => "45HC", "description"  => "45'HC", "created_at" => now() ], 
        ]); 
    }
}
