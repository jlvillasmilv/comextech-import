<?php

namespace App\Http\Livewire;

use App\CustomAgent;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;

class CustomAgentTable extends LivewireDatatable
{
    public $model = CustomAgent::class;

    public function columns()
    {
        return [
            NumberColumn::name('id')
                ->label('ID'),

            Column::name('name')
            ->defaultSort('asc')
            ->searchable()
            ->label('Nombre'),

            Column::name('contact_person')
            ->searchable()
            ->label('Persona de contacto'),

            Column::callback(['id'], function ($id) {
                return view('table-actions', ['id' => $id, 'route' => 'admin.warehouses.']);
            })
        ];
    }
}