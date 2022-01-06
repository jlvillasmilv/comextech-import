<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use View;

class ComposerServiceProvider extends ServiceProvider
{

    public function boot()
    {

        View::composer('admin.users.form', 'App\Http\ViewComposers\UserComposer');
        View::composer([
            'admin.rates.fcl.form',
            'admin.rates.lcl.form',
            'admin.customs_exchange_rates.form', 
        ],
         'App\Http\ViewComposers\PortsComposer');


        View::composer('admin.rates.local_transport.form', 'App\Http\ViewComposers\LocalTranspComposer');
        View::composer('admin.rates.local_spending.form', 'App\Http\ViewComposers\TransCompaniesComposer');
         
        
        View::composer('admin.applications.form', 'App\Http\ViewComposers\ApplicationStatuses');
        View::composer('admin.services.form', 'App\Http\ViewComposers\CategoryServiceComposer');
        View::composer('supplier.form', 'App\Http\ViewComposers\SupplierComposer');
        View::composer('profile.address.form', 'App\Http\ViewComposers\AddressComposer');
        View::composer('factoring.bank_account.form', 'App\Http\ViewComposers\BanksComposer');
        View::composer('admin.clients.form', 'App\Http\ViewComposers\ExecutiveComposer');
        
        //factoring
        View::composer([
            'factoring.application.index',
            'factoring.profile.index',
            'factoring.disbursements.index'],
             'App\Http\ViewComposers\successMountComposer');

        View::composer(['factoring.application.index'], 'App\Http\ViewComposers\TotalApplicationsClient');
        View::composer([
            'factoring.disbursements.index',
            'layouts.partitions._collapse'
        ],
         'App\Http\ViewComposers\TotalDisbursementsClient');
    }

    public function register()
    {
        //
    }

}
