<?php

namespace App\Http\Livewire\Admin\Factoring;

use App\Models\Factoring\ClientPayer;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;

class FeeHistoryTable extends LivewireDatatable
{
    public $model = ClientPayer::class;

    public function columns()
    {
        $table = [

            Column::name('payer.rut')
            ->searchable(),

            Column::name('payer.name')
            ->label('Pagador')
            ->searchable(),

            Column::name('client.company.tax_id')
            ->label('Cliente Rut'),

            Column::name('client.company.name')
            ->label('Cliente Nombre'),

            Column::name('SettlementStatus.description')
            ->label('Liquidacion'),
            
         
            Column::callback(['id'], function ($id) {
                return view('table-actions', ['id' => base64_encode($id), 'route' => 'admin.factoring.fee_history.', 'permission' => 'admin.factoring.fee_history']);
            })
        ];

        return $table;
    }
}