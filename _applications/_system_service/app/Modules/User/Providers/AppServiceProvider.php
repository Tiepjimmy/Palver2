<?php

namespace App\Modules\User\Providers;

use App\Modules\User\Repositories\Contracts\TenancyContractRepositoryInterface;
use App\Modules\User\Repositories\Eloquent\TenancyContractRepository;
use App\Modules\User\Repositories\Contracts\UserRepositoryInterface;
use App\Modules\User\Repositories\Eloquent\UserRepository;
use App\Modules\User\Services\Impls\UserService;
use App\Modules\User\Services\IUserService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public $bindings = [
        UserRepositoryInterface::class => UserRepository::class,
        TenancyContractRepositoryInterface::class => TenancyContractRepository::class,
        IUserService::class => UserService::class,

    ];

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }
}
