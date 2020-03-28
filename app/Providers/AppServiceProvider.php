<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //Allows load CSS styles in SSL
        // if(env('REDIRECT_HTTPS')) {
        //     $this->app['request']->server->set('HTTPS', true);
        // }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if(App::environment() === 'production')
        {
            URL::forceScheme('https'); 
            //$url->forceSchema('https');
        }
        // if($this->app->environment() === 'production')
        // { 
        //     URL::forceScheme('https');
        // }
    }
}
