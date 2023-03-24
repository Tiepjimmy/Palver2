<?php

namespace App\Modules\Authentication\Providers;

use App\Modules\Authentication\Repositories\Contracts\TenancyContractRepositoryInterface;
use App\Modules\Authentication\Repositories\Contracts\UserRepositoryInterface;
use App\Modules\Authentication\Repositories\Eloquent\TenancyContractRepository;
use App\Modules\Authentication\Repositories\Eloquent\UserRepository;
use App\Modules\Authentication\Services\Impls\TenancyServiceImpl;
use App\Modules\Authentication\Services\ITenancyService;
use Database\Seeders\Modules\Authentication\Mock\TenancySeeder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public $bindings = [
        #service
        ITenancyService::class => TenancyServiceImpl::class,
        #repository
        UserRepositoryInterface::class => UserRepository::class,
        TenancyContractRepositoryInterface::class => TenancyContractRepository::class,

    ];

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
