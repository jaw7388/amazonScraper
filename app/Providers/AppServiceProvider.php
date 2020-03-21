<?php

namespace App\Providers;

use Illuminate\Routing\UrlGenerator;

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
        //UrlGenerator $url
        //Allows load CSS styles in SSL
        // if(env('REDIRECT_HTTPS')) {
        //     $url->formatScheme('https');
        // }
        if(config('app.env') === 'production') {
            \URL::forceScheme('https');
        }
    }
}
