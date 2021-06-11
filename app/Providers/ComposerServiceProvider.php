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
        
        
    }

    public function register()
    {
        //
    }

}
