<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use View;

class ComposerServiceProvider extends ServiceProvider
{

    public function boot()
    {

        View::composer('admin.users.form', 'App\Http\ViewComposers\UserComposer');
     
    }

    public function register()
    {
        //
    }

}
