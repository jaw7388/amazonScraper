<?php

namespace App\Providers;
//namespace Kolovious\MeliSocialite;

use Kolovious\MeliSocialite;

use Laravel\Socialite\Two\AbstractProvider;
use Laravel\Socialite\Two\InvalidStateException;
use Laravel\Socialite\Two\ProviderInterface;
use Laravel\Socialite\Two\User;
use GuzzleHttp\ClientInterface;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\ServiceProvider;

class MeliSocialiteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //// Here we will be registering the facade, but not now yet.
        $this->app->bind('Kolovious\MeliSocialite\MeliManager',function() {
            return new MeliManager(
                            $this->app['config']['services.meli.client_id'],
                            $this->app['config']['services.meli.client_secret']
                        );
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $socialite = $this->app->make('Laravel\Socialite\Contracts\Factory');
        $socialite->extend(
            'meli',
            function ($app) use ($socialite) {
                $config = $app['config']['services.meli'];
                return $socialite->buildProvider(MeliSocialite::class, $config);
            }
        );
    }
}


