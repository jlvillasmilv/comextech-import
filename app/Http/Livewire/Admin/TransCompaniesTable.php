<?php

namespace App\Http\Livewire\Admin;

use App\Models\TransCompany;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;


class TransCompaniesTable extends LivewireDatatable
{
    public $model = TransCompany::class;

    public function columns()
    {
        return [
            NumberColumn::name('id')
                ->label('ID'),

            Column::name('name')
            ->defaultSort('asc')
            ->searchable()
            ->label('Nombre'),

            Column::callback(['id'], function ($id) {
                return view('table-actions', ['id' => $id, 'route' => 'admin.trans_companies.']);
            })->excludeFromExport()
        ];
    }
}