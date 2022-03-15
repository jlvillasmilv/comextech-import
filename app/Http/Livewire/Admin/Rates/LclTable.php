<?php

namespace App\Http\Livewire\Admin\Rates;

use App\Models\RateLcl;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;

class LclTable extends LivewireDatatable
{
    public $model = RateLcl::class;

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
                return view('table-actions', ['id' => base64_encode($id), 'route' => 'admin.rates.lcl.', 'permission' => 'admin.rates.lcl']);
            })->excludeFromExport()
        ];

        return $table;
    }
}