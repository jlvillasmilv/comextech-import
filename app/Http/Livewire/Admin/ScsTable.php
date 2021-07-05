<?php

namespace App\Http\Livewire\Admin;

use App\Models\SupplCondSale;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\NumberColumn;

class ScsTable extends LivewireDatatable
{
    public $model = SupplCondSale::class;

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
                return view('table-actions', ['id' => $id, 'route' => 'admin.suppl_cond_sales.']);
            })
        ];
    }
}