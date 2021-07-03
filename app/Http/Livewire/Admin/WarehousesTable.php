<?php

namespace App\Http\Livewire\Admin;

use App\Models\Warehouse;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;

class WarehousesTable extends LivewireDatatable
{
    public $model = Warehouse::class;

    public function columns()
    {
        return [
            NumberColumn::name('id')
                ->label('ID'),

            Column::name('name')
            ->defaultSort('asc')
            ->searchable()
            ->label('Nombre'),

            Column::name('postal_code')
            ->searchable()
            ->label('Codigo postal'),

            Column::callback(['id'], function ($id) {
                return view('table-actions', ['id' => $id, 'route' => 'admin.warehouses.']);
            })
        ];
    }
}