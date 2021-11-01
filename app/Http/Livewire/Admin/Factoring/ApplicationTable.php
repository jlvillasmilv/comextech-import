<?php

namespace App\Http\Livewire\Admin\Factoring;

use App\Models\Factoring\Application;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;

class ApplicationTable extends LivewireDatatable
{
    public $model = Application::class;

    public function columns()
    {
        // admin.factoring.applications

        $table = [

            NumberColumn::name('id'),

            Column::name('company.tax_id')
            ->label('Rut'),

            Column::name('company.name')
            ->label('Cliente')
            ->searchable(),

            DateColumn::name('created_at')
            ->searchable()
            ->label('Fecha Solicitud'),

            NumberColumn::name('invoices.total_amount:sum')
            ->label('Monto Total'),

            Column::name('status')
            ->searchable()
            ->label('Estado'),

            Column::callback(['id'], function ($id) {
                return view('table-actions', ['id' => base64_encode($id), 'route' => 'bank-accounts.', 'permission' => 'admin.factoring.applications']);
            })
        ];

        return $table;
    }


    public function getCompanyProperty()
    {
        return Company::pluck('name');
    }
}
