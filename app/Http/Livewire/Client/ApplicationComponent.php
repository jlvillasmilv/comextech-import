<?php

namespace App\Http\Livewire\Client;

use App\Models\Application;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;
use App\Http\Livewire\WithSorting;

class ApplicationComponent extends Component
{
    use WithPagination;
    use WithSorting;

    public int $perPage;

    public array $orderable;

    public string $search = '';

    public array $selected = [];

    public array $paginationOptions;

    public $sortField;

    public $sortDirection = 'desc';

    protected $queryString = [
        'search' => [ 'except' => ''],
        'sortBy' => ['except' => 'id'],
        'sortDirection' => ['except' => 'desc'],
    ];

    public function getSelectedCountProperty()
    {
        return count($this->selected);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetPage();
        $this->page = 1;
    }

    public function updatedgPerPage()
    {   
        $this->page = 1;
        //$this->resetPage();
    }

    public function resetSelected()
    {
        $this->selected = [];
    }

    public function mount()
    {
        $this->sortBy            = 'code';
        $this->sortDirection     = 'desc';
        $this->perPage           = 5;
        $this->paginationOptions = config('project.pagination.options');
        $this->orderable         = ['code','name','created_at'];
    }

    public function render()
    {
        $datas = Application::advancedFilter([
            's'               => $this->search ?: null,
            'order_column'    => $this->sortBy,
            'order_direction' => $this->sortDirection,
        ])
        ->where('company_id', auth()->user()->company->id)
        ->paginate($this->perPage);

        return view('livewire.client.application.index', compact( 'datas'));

    }
}
