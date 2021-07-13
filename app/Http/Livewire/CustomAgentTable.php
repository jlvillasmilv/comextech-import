<?php

namespace App\Http\Livewire;

use App\Models\{CustomAgent,User};
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;

class CustomAgentTable extends LivewireDatatable
{
    // public $model = CustomAgent::class;

    public function builder()
    {
        if(auth()->user()->hasRole('Client')) { 
            return CustomAgent::where('user_id', auth()->user()->id);
        }

        return CustomAgent::query()->leftJoin('users', 'users.id', 'custom_agents.user_id');
       
    }

    public function columns()
    {

        $table = [
            NumberColumn::name('id')
                ->label('ID'),

            Column::name('name')
            ->defaultSort('asc')
            ->searchable()
            ->label('Nombre'),

            Column::name('contact_person')
            ->searchable()
            ->label('Persona de contacto'),

            DateColumn::name('created_at')
            ->searchable()
            ->label('Fecha de Registro'),

            Column::callback(['id'], function ($id) {
                return view('table-actions', ['id' => base64_encode($id), 'route' => 'custom_agents.', 'delete' => true]);
            })
        ];

        if(auth()->user()->hasRole('Admin')) { 
            
            array_unshift($table,  

                Column::name('users.name')
                    ->label('Usuario')
                    ->searchable(),
            );
        }

        return $table;
    }

    public function getUsersProperty()
    {
        return User::pluck('name');
    }
}