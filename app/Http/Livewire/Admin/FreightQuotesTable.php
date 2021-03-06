<?php

namespace App\Http\Livewire\Admin;

use App\Models\FreightQuote;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class FreightQuotesTable extends LivewireDatatable
{
    public $model = FreightQuote::class;

    public function columns()
    {
        $table = [

            Column::name('code')
            ->searchable(),

            Column::name('customer.name')
            ->label('Cliente')
            ->searchable(),

            NumberColumn::name('transport_amount')
            ->label('Costo transporte'),

            DateColumn::name('created_at')
            ->format('d/m/y')
            ->label('Fecha Solicitud'),

            Column::name('status')
            ->label('Estado'),

            Column::callback(['id'], function ($id) {
                return view('table-actions', ['id' => base64_encode($id), 'route' => 'admin.freight-quotes.', 'permission' => 'admin.freight-quotes']);
            })->excludeFromExport()
        ];

        return $table;
    }
}