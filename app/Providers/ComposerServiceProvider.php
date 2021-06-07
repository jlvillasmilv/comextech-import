<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use View;

class ComposerServiceProvider extends ServiceProvider
{

    public function boot()
    {

        View::composer('admin.users.form', 'App\Http\ViewComposers\UserComposer');
        View::composer('admin.applications.form', 'App\Http\ViewComposers\ApplicationStatuses');
        
    }

    public function register()
    {
        //
    }

}
