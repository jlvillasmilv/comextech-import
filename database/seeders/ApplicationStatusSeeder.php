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
            'name' => 'Borrador',
            'status_icon' => 'far fa-clock fa-2x',
            'status_color' => 'bg-gray-100',
            'modify' => true,
            'client_modify' => true,
            'rank' => 0
        ]); 

        ApplicationStatus::create([
            'name' => 'Autorizada',
            'status_icon' => 'fa fa-times fa-2x',
            'status_color' => 'bg-blue-100',
            'modify' => true,
            'rank' => 1
        ]);

        ApplicationStatus::create([
            'name' => 'Validada',
            'status_icon' => 'fa fa-clipboard-check fa-2x',
            'status_color' => 'bg-green-100',
            'modify' => false,
            'rank' => 2
        ]);

        ApplicationStatus::create([
            'name' => 'Rechazado',
            'status_icon' => 'fa fa-times fa-2x',
            'status_color' => 'bg-red-100',
            'modify' => false,
            'rank' => 2
        ]);

    }
}
