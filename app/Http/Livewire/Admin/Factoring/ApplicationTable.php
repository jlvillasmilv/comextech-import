<?php

namespace App\Http\Livewire\Admin\Factoring;

use App\Models\Factoring\{Application,Invoice};
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

            Column::name('code')
            ->searchable(),

            Column::name('user.company.tax_id')
            ->searchable()
            ->excludeFromExport()
            ->label('Rut'),

            Column::name('user.company.name')
            ->label('Cliente')
            ->excludeFromExport()
            ->searchable(),

            DateColumn::name('created_at')
            ->format('d/m/y')
            ->label('Fecha Solicitud'),

            // Column::name('invoices.total_amount:sum')
            // ->label('Monto Total'),

            Column::name('status')
            ->searchable()
            ->label('Estado'),

            Column::callback(['id'], function ($id) {
                return view('table-actions', ['id' => base64_encode($id), 'route' => 'admin.factoring.applications.', 'permission' => 'admin.factoring.applications']);
            })->excludeFromExport()
        ];

        return $table;
    }


    public function getCompanyProperty()
    {
        return Company::pluck('name');
    }

    public function getInvoicesProperty()
    {
        return Invoice::all();
    }
}
