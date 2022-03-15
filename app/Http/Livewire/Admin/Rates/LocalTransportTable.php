<?php

namespace App\Http\Livewire\Admin\Rates;

use App\Models\RateLocalTransport;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\{Column, NumberColumn};

class LocalTransportTable extends LivewireDatatable
{
    public $model = RateLocalTransport::class;

    public function columns()
    {
        $table = [

            Column::name('from'),

            Column::name('to')
            ->label('To'),

            NumberColumn::name('weight')
            ->label('Peso')
            ->searchable(),

            NumberColumn::name('weight_limit')
            ->label('Limite')
            ->searchable(),

            NumberColumn::name('amount')
            ->label('Monto')
            ->searchable(),

            Column::callback(['id'], function ($id) {
                return view('table-actions', ['id' => base64_encode($id), 'route' => 'admin.rates.local-transport.', 'permission' => 'admin.rates.local-transport']);
            })->excludeFromExport()
        ];

        return $table;
    }
}