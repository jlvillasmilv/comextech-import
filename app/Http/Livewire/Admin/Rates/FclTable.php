<?php

namespace App\Http\Livewire\Admin\Rates;

use App\Models\RateFcl;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\{Column, NumberColumn};
;


class FclTable extends LivewireDatatable
{
    public $model = RateFcl::class;

    public function columns()
    {
        $table = [

            Column::name('from')
            ->searchable(),

            Column::name('to')
            ->searchable()
            ->label('To'),

            NumberColumn::name('via')
            ->label('VIA')
            ->searchable(),

            NumberColumn::name('t_time')
            ->label('Transit time'),

            Column::name('currency')
            ->searchable()
            ->label('Moneda'),

            Column::callback(['id'], function ($id) {
                return view('table-actions', [
                    'id'         => base64_encode($id),
                    'route'      => 'admin.rates.fcl.',
                    'permission' => 'admin.rates.fcl'
                ]);
            })->excludeFromExport()
        ];

        return $table;
    }
}