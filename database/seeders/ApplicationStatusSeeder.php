<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ApplicationStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Models\ApplicationStatus::create([
            'name' => 'PENDIENTE',
            'status_icon' => 'far fa-clock fa-2x',
            'status_color' => '#6c757d',
            'modify' => true,
            'rank' => 0,
            'created_at' => now(),
        ]);
    }
}
