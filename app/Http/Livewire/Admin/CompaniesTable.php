<?php

namespace App\Http\Livewire\Admin;

use App\Models\{Company, User};
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class CompaniesTable extends LivewireDatatable
{

    public function builder()
    {
        return Company::query();
    }

    public function columns()
    {
        return [
            Column::name('tax_id')->searchable()->label('RUT'),

            Column::name('name')->searchable()->label('Nombre'),

            Column::name('user.name')->searchable()->label('Usuario'),

            // Column::callback(['user.name', 'user.email'], function ($name, $allegiance) { 
            //     return "$name | $allegiance"; 
            // })->searchable()->filterOn('users.name')->label('Usuario'),

            Column::callback(['id'], function ($id) {
                $company = Company::with('user')->where('id', $id)->first();
                return view('admin.clients.table-actions', ['id' => $id, 'route' => 'admin.clients.', 'company' => $company]);
            })->excludeFromExport()
        ];
    }

    public function getUsersProperty()
    {
        return User::pluck('name');
    }
}