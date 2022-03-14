<?php

namespace App\Http\Livewire\Admin;

use App\Models\TransportMode;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\BooleanColumn;

class TransportModesTable extends LivewireDatatable
{
    public $model = TransportMode::class;
    public $exportable = true;
    public $complex = true;

    public function columns()
    {
        return [
            NumberColumn::name('id')
                ->label('ID')
                ->sortBy('id')
                ->defaultSort('asc'),
            // ->editable()
            Column::name('name')
            ->defaultSort('asc')
            ->searchable()
            ->label('Nombre'),

            BooleanColumn::name('status'),
            BooleanColumn::name('disabled')->label('Deshabilitado'),

            Column::callback(['id'], function ($id) {
                return view('table-actions', ['id' => $id, 'route' => 'admin.transport-modes.']);
            })->excludeFromExport()

           
        ];
    }
}