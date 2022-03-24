<?php

namespace App\Http\Livewire\Admin;

use App\Models\CustomsExchangeRate;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class ActionsCustomsExchangeRateTable extends LivewireDatatable
{
    public $model = CustomsExchangeRate::class;

    public function columns()
    {
        return [
            NumberColumn::name('id'),

            Column::name('currency_code')
            ->searchable()
            ->label('Moneda'),

            NumberColumn::name('amount')->label('Monto'),

            DateColumn::name('exchange')->label('Fecha'),
    
            Column::callback(['id'], function ($id) {
                return view('table-actions', [
                    'id' => base64_encode($id),
                    'route' => 'admin.customs-exchange-rates.',
                    'permission' => 'admin.customs-exchange-rates'
                ]);
            })->excludeFromExport()
        ];
    }

}