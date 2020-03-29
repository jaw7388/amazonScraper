<?php

namespace App\Providers;

use App\Amazon\CREATE;
use App\Amazon\XPATH;

use Illuminate\Support\ServiceProvider;

class AmazonServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // $this->app->singleton(CREATE::class, function ($app, $asin) {
        //     return new CREATE($asin);
        // });

        // $this->app->singleton(XPATH::class, function ($app, $url) {
        //     return new XPATH($url);
        // });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        

    }
}
