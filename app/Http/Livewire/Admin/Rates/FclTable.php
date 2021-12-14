<?php

namespace App\Http\Livewire\Admin\Rates;

use App\Models\RateFcl;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;

class FclTable extends LivewireDatatable
{
    public $model = RateFcl::class;

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
                return view('table-actions', [
                    'id'         => base64_encode($id),
                    'route'      => 'admin.rates.fcl.',
                    'permission' => 'admin.rates.fcl'
                ]);
            })
        ];

        return $table;
    }
}