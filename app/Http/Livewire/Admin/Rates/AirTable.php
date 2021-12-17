<?php

namespace App\Http\Livewire\Admin\Rates;

use App\Models\RateAir;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;

class AirTable extends LivewireDatatable
{
    public $model = RateAir::class;

    public function columns()
    {
        $table = [

            Column::name('from'),

            Column::name('to')
            ->label('To'),

            Column::name('via')
            ->label('VIA')
            ->searchable(),

            Column::name('t_time')
            ->searchable()
            ->label('Transit time'),

            Column::callback(['id'], function ($id) {
                return view('table-actions', ['id' => base64_encode($id), 'route' => 'admin.rates.air.', 'permission' => 'admin.rates.air']);
            })
        ];

        return $table;
    }
}