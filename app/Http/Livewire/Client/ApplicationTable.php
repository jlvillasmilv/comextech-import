<?php

namespace App\Http\Livewire\Client;

use App\Models\Application;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;

class ApplicationTable extends LivewireDatatable
{
    public $model = Application::class;

    public function columns()
    {
        return [
            NumberColumn::name('id'),

            Column::name('code')->searchable()->label('Codigo'),
            Column::name('code')->searchable()->label('Codigo'),

            // Column::callback(['id'], function ($id) {
            //     return view('table-actions', ['id' => $id, 'route' => 'admin.category_service.']);
            // })
        ];
    }
}