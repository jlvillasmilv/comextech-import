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

            Column::name('from')
            ->searchable(),

            Column::name('to')
            ->searchable()
            ->label('To'),

            NumberColumn::name('weight')
            ->label('Peso'),

            NumberColumn::name('weight_limit')
            ->label('Limite'),

            NumberColumn::name('amount')
            ->label('Monto'),

            Column::callback(['id'], function ($id) {
                return view('table-actions', ['id' => base64_encode($id), 'route' => 'admin.rates.local-transport.', 'permission' => 'admin.rates.local-transport']);
            })->excludeFromExport()
        ];

        return $table;
    }
}