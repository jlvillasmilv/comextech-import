<?php

namespace App\Http\Livewire\Admin\Factoring;

use App\Models\Factoring\{Disbursement,Invoice};
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;

class DisbursementTable extends LivewireDatatable
{
    public $model = Disbursement::class;


    public function columns()
    {
        // admin.factoring.applications

        $table = [

            NumberColumn::name('id'),

            Column::name('factoring_application_id')
            ->label('Solicitud'),

            Column::name('application.user.company.name')
            ->label('Cliente')
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
                return view('table-actions', ['id' => base64_encode($id), 'route' => 'admin.factoring.disbursements.', 'permission' => 'admin.factoring.disbursements']);
            })
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
