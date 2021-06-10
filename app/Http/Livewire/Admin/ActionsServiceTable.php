<?php

namespace App\Http\Livewire\Admin;

use App\Models\Service;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class ActionsServiceTable extends LivewireDatatable
{
    public $model = Service::class;

    public function columns()
    {
        return [
            NumberColumn::name('id'),

            Column::name('name')->searchable()->label('Nombre'),

            Column::callback(['id'], function ($id) {
                return view('table-actions', ['id' => $id, 'route' => 'admin.services.']);
            })
        ];
    }
}