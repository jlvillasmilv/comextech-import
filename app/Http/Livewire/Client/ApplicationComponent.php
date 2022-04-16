<?php

namespace App\Http\Livewire\Client;

use App\Models\{Application, ApplicationSummary, PaymentProvider, Transport, Load};   
use App\Models\{InternmentProcess, FileStoreInternment, FileStore};   
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

    protected $listeners = ['setApplicationSummary','delete'];

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
        $this->orderable         = ['code','supplier.name','created_at'];
    }

    /**
     * updates costs of the summary of an application to the current exchange rate
     *
     * @param  \App\Models\Application  $id
     * @return \Illuminate\Http\Response
    */
    public function setApplicationSummary($id)
    {
        $application = Application::where([
            ['id', base64_decode($id)],
            ['company_id', auth()->user()->company->id],
        ])->firstOrFail();

        $data  = [
            'application_id' => base64_encode($application->id),
            'currency_code' => null,
            'user_id'       => auth()->user()->id
        ];

        $total = ApplicationSummary::setSummary($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  @param  \App\Models\Application  $id
     * @return \Illuminate\Http\Response
    */
    public function delete($id)
    {
        $application = Application::where([
            ['id', base64_decode($id)],
            ['company_id', auth()->user()->company->id],
        ])->firstOrFail();

        PaymentProvider::where('application_id',  $application->id)->delete();
        Transport::where('application_id',  $application->id)->delete();

        if(Load::where('application_id',  $application->id)->exists()){
            Load::where('application_id',  $application->id)->delete();
        }

        if(isset($application->internmentProcess->fileStoreInternment)){

            foreach ($application->internmentProcess->fileStoreInternment as $key => $item) {
              
                $exists = \Storage::disk('s3')
                ->exists('file/'.$item->fileStore->file_name);
    
                // if($exists){
                //     \Storage::disk('s3')
                //     ->delete('file/'.$item->fileStore->file_name);
                // }
    
                FileStoreInternment::where('id', $item->id)->delete();
    
                if (!is_null($item->fileStore->id)) {
                    FileStore::where('id', $item->fileStore->id)->delete();
                }
    
            }

        }

        InternmentProcess::where('application_id', $application->id)->delete();

        $application->delete();

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
