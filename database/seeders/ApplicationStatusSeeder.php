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

        ApplicationStatus::create([
            'name' => 'RECHAZADO',
            'status_icon' => 'fa fa-times fa-2x',
            'status_color' => 'red',
            'modify' => false,
            'rank' => 1,
            'created_at' => now(),
        ]);

        ApplicationStatus::create([
            'name' => 'APROBADO',
            'status_icon' => 'fa fa-clipboard-check fa-2x',
            'status_color' => '#00BD2D',
            'modify' => false,
            'rank' => 3,
            'created_at' => now(),
        ]);


    }
}
