<?php

namespace App\Providers;


use Kolovious\MeliSocialite\MeliSocialite as MeliSocialite;
use Kolovious\MeliSocialite\MeliManager;

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

    public function queryget()
    {    
        $access_token = User::where('id', Auth::user()->id )->firstOrFail();
        $params = array('access_token' => $access_token->token);
        $result = Meli::get('/users/me', $params, true); 

    }
}