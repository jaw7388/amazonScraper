<?php

namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

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
    public function boot(Dispatcher $events)
    {
        //UrlGenerator $url
        //Allows load CSS styles in SSL
        // if(env('REDIRECT_HTTPS')) {
        //     $url->formatScheme('https');
        // }
        if(config('app.env') === 'production') {
            \URL::forceScheme('https');
        }


        $events->listen(BuildingMenu::class, function (BuildingMenu $event) {
            $event->menu->addAfter('blog', [
                'key' => 'account_settings',
                'text' => 'Account Settings',
                'topnav' => true,
            ]);
            $event->menu->addIn('account_settings', [
                'key' => 'account_settings_notifications',
                'text' => 'Notifications',
                'url' => 'account/edit/notifications',
            ]);
            $event->menu->addBefore('account_settings_notifications', [
                'key' => 'account_settings_profile',
                'text' => 'Profile',
                'url' => 'account/edit/profile',
            ]);
        });

    }
}
