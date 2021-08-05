<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use View;

class ComposerServiceProvider extends ServiceProvider
{

    public function boot()
    {

        View::composer('admin.users.form', 'App\Http\ViewComposers\UserComposer');
        View::composer('admin.applications.form', 'App\Http\ViewComposers\ApplicationStatuses');
        View::composer('admin.services.form', 'App\Http\ViewComposers\CategoryServiceComposer');
        View::composer('supplier.form', 'App\Http\ViewComposers\SupplierComposer');
        View::composer('address.form', 'App\Http\ViewComposers\AddressComposer');
        
    }

    public function register()
    {
        //
    }

}
