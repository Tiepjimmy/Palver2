<?php

namespace App\Providers;

use AccountSdkDb\Modules\Authentication\Providers\PalUserProvider;
use Illuminate\Support\Facades\Auth;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Auth::provider('PalUserProvider', function ($app, array $config) {
            return new PalUserProvider($app['hash'], $config['model']);
        });
    }
}
