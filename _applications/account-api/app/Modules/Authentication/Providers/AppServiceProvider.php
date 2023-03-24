<?php

/**
 * Class AppServiceProvider
 * @package App\Modules\Example\Providers
 */

namespace App\Modules\Authentication\Providers;

use AccountSdkDb\Modules\Authentication\Providers\PalUserProvider;
use App\Modules\Authentication\Repositories\Contracts\UserRepositoryInterface;
use App\Modules\Authentication\Repositories\Eloquent\UserRepository;
use App\Modules\Authentication\Services\IAuthService;
use App\Modules\Authentication\Services\Impls\AuthService;
use App\Modules\Authentication\Services\Impls\RoleServiceImpl;
use App\Modules\Authentication\Services\Impls\SecretService;
use App\Modules\Authentication\Services\IRoleService;
use App\Modules\Authentication\Services\ISecretProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use \Common\Auth\Contracts\ISecretProvider as BaseSecretProvider;

class AppServiceProvider extends ServiceProvider
{

    public $bindings = [
        #Service
        IAuthService::class => AuthService::class,
        ISecretProvider::class => SecretService::class,
        BaseSecretProvider::class => SecretService::class,
        IRoleService::class => RoleServiceImpl::class,

        #Repository
        UserRepositoryInterface::class => UserRepository::class

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
