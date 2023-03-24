<?php

namespace App\Providers;

use App\Http\Providers\PalUserProvider;
use App\Services\Impls\SecretProviderImpl;
use App\Services\Proxies\ProxyServiceFactory;
use Common\Auth\Contracts\ISecretProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public $bindings = [
        ProxyServiceFactory::class => ProxyServiceFactory::class,
        ISecretProvider::class => SecretProviderImpl::class
    ];

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
