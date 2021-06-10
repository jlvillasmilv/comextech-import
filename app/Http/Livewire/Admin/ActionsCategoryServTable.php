<?php

namespace App\Http\Livewire\Admin;

use App\Models\CategoryService;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class ActionsCategoryServTable extends LivewireDatatable
{

    public $model = CategoryService::class;

    public function columns()
    {
        return [
            NumberColumn::name('id'),

            Column::name('name')->searchable()->label('Nombre'),

            Column::callback(['id'], function ($id) {
                return view('table-actions', ['id' => $id, 'route' => 'admin.category_service.']);
            })
        ];
    }
}