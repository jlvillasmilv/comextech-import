<?php

namespace App\Http\Livewire\Admin\Rates;

use App\Models\RateLCE;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\{Column, NumberColumn};

class LocalSpendingTable extends LivewireDatatable
{
   public $model = RateLCE::class;

    public function columns()
    {
        $table = [

            Column::name('transCompany.name')
            ->searchable()
            ->label('Empresa'),

            NumberColumn::name('val_init')
            ->label('Valor PRODUCTO (USD)'),

            NumberColumn::name('val_limit')
            ->label('Valor limite (USD)'),

            NumberColumn::name('rate')
            ->label('Tarifa USD'),

            Column::callback(['id'], function ($id) {
                return view('table-actions', ['id' => base64_encode($id), 'route' => 'admin.rates.local-spending.', 'permission' => 'admin.rates.local_spending']);
            })
        ];

        return $table;
    }

    public function getTransCompanyProperty()
    {
        return TransCompany::pluck('name');
    }
}