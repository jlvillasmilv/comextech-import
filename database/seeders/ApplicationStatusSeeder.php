<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ApplicationStatus;

class ApplicationStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ApplicationStatus::create([
            'name' => 'PENDIENTE',
            'status_icon' => 'far fa-clock fa-2x',
            'status_color' => '#6c757d',
            'modify' => true,
            'rank' => 0,
            'created_at' => now(),
        ]);
    }
}
